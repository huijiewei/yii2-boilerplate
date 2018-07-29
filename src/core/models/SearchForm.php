<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/26
 * Time: 10:10
 */

namespace app\core\models;

use app\core\components\Model;
use app\extensions\spreadsheet\Spreadsheet;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;

abstract class SearchForm extends Model
{
    public $field;
    public $keyword;

    public $searchFields = false;
    public $isPagination = true;

    public $defaultPageSize = 10;

    public function rules()
    {
        return [
            [['field', 'keyword', 'searchFields'], 'trim'],
            ['searchFields', 'boolean'],
        ];
    }

    /**
     * @return Spreadsheet|null
     */
    public function export()
    {
        $options = $this->exportOptions();

        if ($options === null || empty($options)) {
            return null;
        }

        $options['query'] = $this->getQuery();

        return new Spreadsheet($options);
    }

    /**
     * @return array|null
     */
    abstract public function exportOptions();

    abstract protected function getQuery();

    /**
     * @return DataProviderInterface
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => $this->getQuery(),
            'pagination' => $this->isPagination ? [
                'defaultPageSize' => $this->defaultPageSize,
            ] : false,
        ]);
    }

    /**
     * @return array|null
     */
    abstract public function searchFields();
}
