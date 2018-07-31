<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/28
 * Time: 16:32
 */

namespace app\core\components;

use app\core\models\SearchForm;
use yii\base\Arrayable;
use yii\base\Component;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\Response;

class RestSerializer extends Component
{
    public $fieldsParam = 'fields';
    public $expandParam = 'expand';

    /* @var Request */
    public $request;

    /* @var Response */
    public $response;

    public function init()
    {
        if ($this->request === null) {
            $this->request = \Yii::$app->getRequest();
        }
        if ($this->response === null) {
            $this->response = \Yii::$app->getResponse();
        }
    }

    public function serialize($data)
    {
        if ($data instanceof \yii\base\Model && $data->hasErrors()) {
            return $this->serializeModelErrors($data);
        } elseif ($data instanceof SearchForm) {
            return $this->serializeSearchForm($data);
        } elseif ($data instanceof Arrayable) {
            return $this->serializeModel($data);
        } elseif ($data instanceof DataProviderInterface) {
            return $this->serializeDataProvider($data);
        }

        return $data;
    }

    /**
     * @param $model \yii\base\Model
     *
     * @return array
     */
    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');

        $result = [];

        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'message' => $message,
            ];
        }

        return $result;
    }

    /**
     * @param $form SearchForm
     *
     * @return array
     */
    protected function serializeSearchForm($form)
    {
        $dataProvider = $form->search();

        $result = $this->serializeDataProvider($dataProvider);

        if ($form->searchFields) {
            $result['searchFields'] = $form->searchFields();
        }

        return $result;
    }

    /**
     * @param $dataProvider DataProviderInterface
     *
     * @return array|null
     */
    protected function serializeDataProvider($dataProvider)
    {
        $result = [];

        $result['items'] = $this->serializeModels($dataProvider->getModels());

        $pagination = $dataProvider->getPagination();

        if ($pagination !== false) {
            $result['pages'] = $this->serializePagination($pagination);
        }

        return $result;
    }

    /**
     * @param array $models
     *
     * @return array
     */
    protected function serializeModels(array $models)
    {
        list($fields, $expand) = $this->getRequestedFields();

        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                $models[$i] = $model->toArray($fields, $expand);
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model);
            }
        }

        return $models;
    }

    /**
     * @return array
     */
    protected function getRequestedFields()
    {
        $fields = $this->request->get($this->fieldsParam);
        $expand = $this->request->get($this->expandParam);

        return [
            is_string($fields) ? preg_split('/\s*,\s*/', $fields, -1, PREG_SPLIT_NO_EMPTY) : [],
            is_string($expand) ? preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY) : [],
        ];
    }

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
     * @param $model Arrayable
     *
     * @return array
     */
    protected function serializeModel($model)
    {
        list($fields, $expand) = $this->getRequestedFields();

        return $model->toArray($fields, $expand);
    }
}
