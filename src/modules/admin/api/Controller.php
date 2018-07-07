<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:29
 */

namespace app\modules\admin\api;

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
 * @method Admin getIdentity()
 *
 * @package app\modules\admin\api
 */
class Controller extends RestController
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/vnd.api+json' => Response::FORMAT_JSON,
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
                'class' => HttpHeaderAuth::class,
                'header' => 'ADMIN-ACCESS-TOKEN',
                'optional' => [
                    'site/error', 'auth/*', 'site/menus',
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'except' => [
                    'auth/login', 'site/*',
                ],
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
            ],
        ];
    }
}
