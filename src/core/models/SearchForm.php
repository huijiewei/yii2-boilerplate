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
use yii\data\Pagination;

abstract class SearchForm extends Model
{
    public $field;
    public $keyword;
    public $searchFields = false;

    public function rules()
    {
        return [
            [['field', 'keyword', 'searchFields'], 'trim'],
            ['searchFields', 'boolean'],
        ];
    }

    public function search()
    {
        $data = new ActiveDataProvider([
            'query' => $this->getQuery()
        ]);

        $result = [
            'items' => $data->getModels(),
            'pages' => $this->serializePagination($data->getPagination()),
        ];

        if ($this->searchFields) {
            $result['searchFields'] = $this->searchFields();
        }

        return $result;
    }

    abstract protected function getQuery();

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

    /**
     * @return array
     */
    abstract protected function searchFields();
}
