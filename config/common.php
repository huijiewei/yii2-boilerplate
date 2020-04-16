<?php

$db = require(__DIR__ . '/db.php');

$serverTimeZone = getenv('APP_SERVER_TIMEZONE');

return [
    'name' => getenv('APP_NAME'),
    'language' => 'zh-CN',
    'timeZone' => $serverTimeZone,
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => dirname(__DIR__) . '/runtime',

    'bootstrap' => [
        'log',
        \app\modules\admin\api\ModuleBootstrap::class,
        \app\modules\admin\spa\ModuleBootstrap::class,
        \app\modules\mobile\api\ModuleBootstrap::class,
        \app\modules\mobile\spa\ModuleBootstrap::class,
        \app\modules\website\ModuleBootstrap::class,
        \app\modules\wechat\ModuleBootstrap::class,
    ],

    'aliases' => [
        '@app/web' => dirname(__DIR__) . '/public',
        '@app/migrations' => dirname(__DIR__) . '/database/migrations',
    ],

    'modules' => [
        \app\modules\admin\api\Module::getModuleId() => \app\modules\admin\api\Module::class,
        \app\modules\admin\spa\Module::getModuleId() => \app\modules\admin\spa\Module::class,
        \app\modules\mobile\api\Module::getModuleId() => \app\modules\mobile\api\Module::class,
        \app\modules\mobile\spa\Module::getModuleId() => \app\modules\mobile\spa\Module::class,
        \app\modules\website\Module::getModuleId() => \app\modules\website\Module::class,
        \app\modules\wechat\Module::getModuleId() => \app\modules\wechat\Module::class,
    ],

    'components' => [
        'db' => $db,

        'security' => [
            'passwordHashStrategy' => 'password_hash',
        ],

        'wechat' => [
            'class' => \huijiewei\wechat\Wechat::class,
            'appConfig' => [
                'app_id' => getenv('WECHAT_APP_ID'),
                'secret' => getenv('WECHAT_APP_SECRET'),
            ],
        ],

        'cache' => [
            'class' => getenv('APP_DISABLE_CACHE') == 1 ?
                \yii\caching\DummyCache::class :
                \yii\caching\FileCache::class,
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

        'aliyunUpload' => [
            'class' => \huijiewei\upload\drivers\AliyunOSS::class,
            'accessKeyId' => getenv('ALIYUN_OSS_ACCESS_KEY_ID'),
            'accessKeySecret' => getenv('ALIYUN_OSS_ACCESS_KEY_SECRET'),
            'endpoint' => getenv('ALIYUN_OSS_ENDPOINT'),
            'bucket' => getenv('ALIYUN_OSS_BUCKET'),
            'folder' => getenv('ALIYUN_OSS_FOLDER')
        ],

        'upload' => [
            'class' => \huijiewei\upload\drivers\LocalFile::class,
            'path' => 'uploads',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:40*',
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
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
            ],
            'rules' => [],
        ],
    ],
];
