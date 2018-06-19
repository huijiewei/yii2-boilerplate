<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 15:44
 */

$common = require(__DIR__ . '/common.php');

$config = [
    'id' => 'bp-website',
    'name' => '样板项目网站应用',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'components' => [
        'request' => [
            'class' => \app\core\WebRequest::class,
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
        ],
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];
}

return \yii\helpers\ArrayHelper::merge($common, $config);
