<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:15
 */

$db = require(__DIR__ . '/db.php');

$serverTimeZone = getenv('SERVER_TIMEZONE');

return [
    'id' => 'boilerplate',
    'name' => '样板项目',
    'language' => 'zh-CN',
    'timeZone' => $serverTimeZone,
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => dirname(__DIR__) . '/runtime',

    'bootstrap' => [
        'log',
        'website',
    ],

    'aliases' => [
        '@app/web' => dirname(__DIR__) . '/public',
    ],

    'modules' => [
        'website' => \app\modules\website\Module::class,
    ],

    'components' => [
        'db' => $db,

        'security' => [
            'passwordHashStrategy' => 'password_hash',
        ],

        'cache' => [
            'class' => \yii\caching\DummyCache::class,
        ],

        'formatter' => [
            'defaultTimeZone' => $serverTimeZone,
            'timeZone' => $serverTimeZone,
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm',
            'nullDisplay' => '',
        ],

        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                        'yii\web\HttpException:405',
                        'yii\web\HttpException:406',
                        'yii\web\HttpException:422',
                        'yii\web\HttpException:429',
                    ],
                    'logVars' => [],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info'],
                    'categories' => ['debug'],
                    'logFile' => '@runtime/logs/debug.log',
                    'logVars' => [],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info'],
                    'categories' => ['wechat'],
                    'logFile' => '@runtime/logs/wechat.log',
                    'logVars' => [],
                ],
            ]
        ],

        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'rules' => [
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
];
