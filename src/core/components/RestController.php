<?php

namespace app\core\components;

use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

abstract class RestController extends Controller
{
    public $serializer = [
        'class' => RestSerializer::class,
    ];

    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => Cors::class,
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
            ],
        ];
    }

    protected function verbs()
    {
        return [];
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $this->serializeData($result);
    }

    protected function serializeData($data)
    {
        return \Yii::createObject($this->serializer)->serialize($data);
    }

    public function addFieldsQueryParams($fields)
    {
        if (is_string($fields)) {
            $fields = [$fields];
        }

        if (count($fields) > 0) {
            $queryParams = \Yii::$app->getRequest()->getQueryParams();

            $currentFields = '';

            if (isset($queryParams['fields']) && !empty($queryParams['fields'])) {
                $currentFields = $queryParams['fields'] . ',';
            }

            $queryParams['fields'] = $currentFields . implode(',', $fields);

            \Yii::$app->getRequest()->setQueryParams($queryParams);
        }
    }

    public function addExpandQueryParams($expand)
    {
        if (is_string($expand)) {
            $expand = [$expand];
        }

        if (count($expand) > 0) {
            $queryParams = \Yii::$app->getRequest()->getQueryParams();

            $currentExpand = '';

            if (isset($queryParams['expand']) && !empty($queryParams['expand'])) {
                $currentExpand = $queryParams['expand'] . ',';
            }

            $queryParams['expand'] = $currentExpand . implode(',', $expand);

            \Yii::$app->getRequest()->setQueryParams($queryParams);
        }
    }

    /**
     * @return null|\yii\web\IdentityInterface
     * @throws \Throwable
     */
    public function getIdentity()
    {
        return \Yii::$app->getUser()->getIdentity();
    }
}
