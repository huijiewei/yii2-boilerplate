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
use yii\data\Pagination;

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

    public function export()
    {
    }

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

    abstract protected function getQuery();

    /**
     * @return array|null
     */
    abstract public function searchFields();

    /**
     * @param $pagination Pagination
     *
     * @return array
     */
    protected function serializePagination($pagination)
    {
        return [
            'totalCount' => $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
            'perPage' => $pagination->getPageSize(),
        ];
    }
}
