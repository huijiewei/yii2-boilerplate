<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/26
 * Time: 10:10
 */

namespace app\core\models;

use app\core\components\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii2tech\spreadsheet\Spreadsheet;

abstract class SearchForm extends Model
{
    public $field;
    public $keyword;

    public $searchFields = false;
    public $isPagination = true;

    public $defaultPageSize = 10;

    public function rules()
    {
        return array_merge($this->searchRules(), [
            [['field', 'keyword', 'searchFields'], 'trim'],
            ['searchFields', 'boolean'],
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
     * @return ActiveQuery
     */
    abstract protected function getQuery();

    /**
     * @return DataProviderInterface
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => $this->searchQuery(),
            'pagination' => $this->isPagination ? [
                'defaultPageSize' => $this->defaultPageSize,
            ] : false,
        ]);
    }

    /**
     * @return ActiveQuery
     */
    private function searchQuery()
    {
        $query = $this->getQuery();

        if (!empty($this->keyword) && !empty($this->field)) {
            $query->andWhere(['like', $this->field, $this->keyword]);
        }

        return $query;
    }

    /**
     * @return array|null
     */
    abstract public function searchFields();
}
