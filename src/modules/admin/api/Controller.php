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
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;

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
                'clientId' => $this->getClientId(),
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

    public function getClientId()
    {
        return \Yii::$app->getRequest()->getHeaders()->get('X-Client-Id', '');
    }
}
