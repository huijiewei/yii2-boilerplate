<?php

namespace app\modules\mobile\api;

use app\core\components\AccessControl;
use app\core\components\HttpHeaderAuth;
use app\core\components\RestController;
use app\core\models\admin\Admin;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Class Controller
 *
 * @property Admin $identity
 * @method Admin getIdentity()
 *
 * @package app\modules\admin\api
 */
abstract class Controller extends RestController
{
    public function behaviors()
    {
        return [
            'content' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'cors' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [
                        'X-Suggested-Filename',
                    ],
                ],
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'auth' => [
                'class' => HttpHeaderAuth::class,
                'header' => 'X-Access-Token',
                'clientId' => $this->getClientId(),
                'optional' => [
                    'auth/login',
                    'site/*',
                    'open/*',
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'except' => [
                    'site/*',
                    'auth/*',
                    'misc/*',
                ],
            ],
            'rate' => [
                'class' => RateLimiter::class,
            ],
        ];
    }

    public function getClientId()
    {
        return \Yii::$app->getRequest()->getHeaders()->get('X-Client-Id', '');
    }

    public function message($message, $data = [])
    {
        return array_merge(['message' => $message], $data);
    }
}
