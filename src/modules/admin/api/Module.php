<?php

namespace app\modules\admin\api;

use app\core\components\AbstractModule;
use app\core\components\WebRequest;
use app\core\models\admin\Admin;
use huijiewei\swagger\SwaggerController;
use yii\web\Application;
use yii\web\Response;
use yii\web\User;

class Module extends AbstractModule
{
    public $disableDebugModule = true;

    public static function getModuleId()
    {
        return 'api';
    }

    public static function getRoutePrefix()
    {
        return 'admin/api';
    }

    public static function getRouteRules()
    {
        return [
            'GET <controller>ies' => '<controller>/index',
            'GET <controller>ies/<id:\d+>' => '<controller>y/view',
            'POST <controller>ies' => '<controller>y/create',
            'PUT <controller>ies/<id:\d+>' => '<controller>y/edit',
            'DELETE <controller>ies/<id:\d+>' => '<controller>y/delete',
            'GET <controller>s' => '<controller>/index',
            'GET <controller>s/<id:\d+>' => '<controller>/view',
            'POST <controller>s' => '<controller>/create',
            'PUT <controller>s/<id:\d+>' => '<controller>/edit',
            'DELETE <controller>s/<id:\d+>' => '<controller>/delete',
            '<controller>/<action>' => '<controller>/<action>',
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

        if (\Yii::$app instanceof Application) {
            \Yii::$app->set('request', [
                'class' => WebRequest::class,
                'enableCsrfValidation' => false,
                'enableCsrfCookie' => false,
                'enableCookieValidation' => false,
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ],
            ]);

            \Yii::$app->set('response', [
                'class' => Response::class,
                'format' => Response::FORMAT_JSON,
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

    public static function getUrlPrefix()
    {
        return 'admin/api';
    }
}
