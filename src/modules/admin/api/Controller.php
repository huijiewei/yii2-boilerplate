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
abstract class Controller extends RestController
{
    public function behaviors()
    {
        return [
            'content' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/vnd.api+json' => Response::FORMAT_JSON,
                ],
            ],
            'cors' => [
                'class' => Cors::class,
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'auth' => [
                'class' => HttpHeaderAuth::class,
                'header' => 'X-Access-Token',
                'optional' => [
                    'auth/login',
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'except' => [
                    'site/*', 'auth/*',
                ],
            ],
            'rate' => [
                'class' => RateLimiter::class,
            ],
        ];
    }
}
