<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:37
 */

namespace app\core\components;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class RestController extends Controller
{
    public $serializer = 'yii\rest\Serializer';

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
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'optional' => [
                    'error', 'login', 'logout'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['user'],
                    ],
                ]
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
            ],
        ];
    }


    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $this->serializeData($result);
    }


    protected function verbs()
    {
        return [];
    }


    protected function serializeData($data)
    {
        return \Yii::createObject($this->serializer)->serialize($data);
    }
}
