<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:03
 */

namespace app\modules\admin\api;

use app\core\components\AbstractModule;
use app\core\components\WebRequest;
use app\core\models\admin\Admin;
use huijiewei\swagger\SwaggerController;
use yii\web\User;

class Module extends AbstractModule
{
    public $disableDebugModule = true;

    public static function getModuleId()
    {
        return 'api';
    }

    public static function getUrlPrefix()
    {
        return 'admin/api';
    }

    public static function getRoutePrefix()
    {
        return 'admin/api';
    }

    public static function getRouteRules()
    {
        return [
            '' => 'site/index',
            '<controller>/<action>' => '<controller>/<action>',
            'GET <controller>s' => '<controller>/index',
            'POST <controller>s' => '<controller>/create',
            'GET <controller>s/<id:\d+>' => '<controller>/view',
            'PUT <controller>s/<id:\d+>' => '<controller>/update',
            'DELETE <controller>s/<id:\d+>' => '<controller>/delete',
            'GET <controller>s/search' => '<controller>/search',
        ];
    }

    public static function getUserComponent()
    {
        return [
            'class' => User::class,
            'identityClass' => Admin::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ];
    }

    public function init()
    {
        parent::init();

        \Yii::$app->set('request', [
            'class' => WebRequest::class,
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
        ]);

        $this->controllerMap = [
            'swagger' => [
                'class' => SwaggerController::class,
                'apiOptions' => [
                    'scanDir' => [
                        '@app/modules/admin/api/Swagger.php',
                        '@app/modules/admin/api/controllers'
                    ],
                    'defines' => [
                        'API_HOST' => \Yii::$app->getRequest()->getHostName(),
                        'API_BASE_PATH' => '/' . static::getUrlPrefix(),
                    ]
                ],
                'uiOptions' => [
                    'apiUrlRoute' => 'swagger/api',
                ]
            ],
        ];
    }
}
