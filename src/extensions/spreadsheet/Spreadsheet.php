<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/28
 * Time: 15:42
 */

namespace app\extensions\spreadsheet;

use app\core\helpers\StringHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Response;

class Spreadsheet extends Component
{
    /* @var ActiveQuery */
    public $query;

    public $batchSize = 100;

    public $title;

    public $columns = [];
    public $headerColumnUnions = [];

    public $emptyCell = '';

    public $nullDisplay = '';

    public $writerType;
    public $rowIndex;

    protected $isRendered = false;

    private $batchInfo;
    private $spreadsheet;

    /* @var ActiveDataProvider */
    private $dataProvider;

    public function configure($properties)
    {
        \Yii::configure($this, $properties);

        return $this;
    }

    public function send($attachmentName, $options = [])
    {
        $tmpFile = \Yii::getAlias('@runtime/temp/' .
            StringHelper::generateNanoId() . '.' .
            pathinfo($attachmentName, PATHINFO_EXTENSION));

        $this->save($tmpFile);

        \Yii::$app->getResponse()->getHeaders()->set('X-Suggested-Filename', rawurlencode($attachmentName));

        \Yii::$app->getResponse()->on(Response::EVENT_AFTER_SEND, function () use ($tmpFile) {
            unlink($tmpFile);
        });

        return \Yii::$app->getResponse()->sendFile($tmpFile, $attachmentName, $options);
    }

    public function save($filename)
    {
        if (!$this->isRendered) {
            $this->render();
        }

        $filename = \Yii::getAlias($filename);
        $writerType = $this->writerType;

        if ($writerType === null) {
            $writerType = ucfirst(strtolower(pathinfo($filename, PATHINFO_EXTENSION)));
        }

        $fileDir = pathinfo($filename, PATHINFO_DIRNAME);

        FileHelper::createDirectory($fileDir);

        $writer = IOFactory::createWriter($this->getDocument(), $writerType);

        $writer->save($filename);
    }

    public function render()
    {
        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'pageSize' => $this->batchSize,
            ],
        ]);

        $document = $this->getDocument();

        if ($this->isRendered) {
            $document->createSheet();
            $document->setActiveSheetIndex($document->getActiveSheetIndex() + 1);
        }

        $activeSheet = $document->getActiveSheet();

        if (!empty($this->title)) {
            $activeSheet->setTitle($this->title);
        }

        $this->rowIndex = 1;

        $columnsInitialized = false;
        $modelIndex = 0;

        while (($data = $this->batchModels()) !== false) {
            list($models, $keys) = $data;

            if (!$columnsInitialized) {
                $columnsInitialized = true;

                $columnIndex = 'A';

                foreach ($this->columns as $name => $field) {
                    $activeSheet->setCellValue(
                        $columnIndex . $this->rowIndex,
                        $name
                    );

                    $columnIndex++;
                }

                $this->rowIndex++;
            }

            foreach ($models as $index => $model) {
                $columnIndex = 'A';

                foreach ($this->columns as $name => $field) {
                    $activeSheet->setCellValue(
                        $columnIndex . $this->rowIndex,
                        ArrayHelper::getValue($model, $field)
                    );

                    $columnIndex++;
                }

                $this->rowIndex++;

                $modelIndex++;
            }

            $this->gc();
        }

        $this->isRendered = true;

        return $this;
    }

    public function getDocument()
    {
        if (!is_object($this->spreadsheet)) {
            $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        return $this->spreadsheet;
    }

    protected function batchModels()
    {
        if ($this->batchInfo === null) {
            if ($this->query !== null && method_exists($this->query, 'batch')) {
                $this->batchInfo = [
                    'queryIterator' => $this->query->batch($this->batchSize)
                ];
            } else {
                $this->batchInfo = [
                    'pagination' => $this->dataProvider->getPagination(),
                    'page' => 0
                ];
            }
        }

        if (isset($this->batchInfo['queryIterator'])) {
            /* @var $iterator \Iterator */
            $iterator = $this->batchInfo['queryIterator'];
            $iterator->next();

            if ($iterator->valid()) {
                return [$iterator->current(), []];
            }

            $this->batchInfo = null;

            return false;
        }

        if (isset($this->batchInfo['pagination'])) {
            /* @var $pagination \yii\data\Pagination|bool */
            $pagination = $this->batchInfo['pagination'];
            $page = $this->batchInfo['page'];

            if ($pagination === false || $pagination->pageCount === 0) {
                if ($page === 0) {
                    $this->batchInfo['page']++;

                    return [
                        $this->dataProvider->getModels(),
                        $this->dataProvider->getKeys()
                    ];
                }
            } else {
                if ($page < $pagination->pageCount) {
                    $pagination->setPage($page);
                    $this->dataProvider->prepare(true);
                    $this->batchInfo['page']++;

                    return [
                        $this->dataProvider->getModels(),
                        $this->dataProvider->getKeys()
                    ];
                }
            }

            $this->batchInfo = null;

            return false;
        }

        return false;
    }

    protected function gc()
    {
        if (!gc_enabled()) {
            gc_enable();
        }
        gc_collect_cycles();
    }
}
