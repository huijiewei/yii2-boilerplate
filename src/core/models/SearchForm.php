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
    public function search()
    {
        $data = new ActiveDataProvider([
            'query' => $this->getQuery()
        ]);

        return [
            'items' => $data->getModels(),
            'pages' => $this->serializePagination($data->getPagination()),
            'searchFields' => $this->searchFields(),
        ];
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
