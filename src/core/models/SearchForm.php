<?php

namespace app\core\models;

use app\core\components\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii2tech\spreadsheet\Spreadsheet;

abstract class SearchForm extends Model
{
    public $isPagination = true;

    public $defaultPageSize = 20;

    public $withSearchFields = false;

    public function rules()
    {
        return array_merge($this->searchRules(), [
            [['withSearchFields'], 'trim'],
            ['withSearchFields', 'boolean'],
        ]);
    }

    abstract public function searchRules();

    /**
     * @return Spreadsheet|null
     */
    public function export()
    {
        $options = $this->exportOptions();

        if ($options === null || empty($options)) {
            return null;
        }

        return new Spreadsheet($options);
    }

    /**
     * @return array|null
     */
    abstract public function exportOptions();

    /**
     * @return DataProviderInterface
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => $this->searchQuery(),
            'pagination' => $this->isPagination ? [
                'defaultPageSize' => $this->defaultPageSize,
                'pageSizeParam' => 'size',
                'pageSizeLimit' => [1, 200]
            ] : false,
        ]);
    }

    /**
     * @return ActiveQuery
     */
    private function searchQuery()
    {
        return $this->getQuery();
    }

    /**
     * @return ActiveQuery
     */
    abstract protected function getQuery();

    /**
     * @return array|null
     */
    abstract public function searchFields();
}
