<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:37
 */

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

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function getIdentity()
    {
        return \Yii::$app->getUser()->getIdentity();
    }
}
