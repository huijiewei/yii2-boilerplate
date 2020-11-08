<?php

$common = require(__DIR__ . '/common.php');

$config = [
    'id' => getenv('APP_ID') . '-console',

    'controllerNamespace' => 'app\\core\\commands',

    'controllerMap' => [
    ],

    'components' => [
        'sqlite' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:' . dirname(__DIR__) . '/database/district.sqlite',
        ],
        'urlManager' => [
            'baseUrl' => getenv('APP_URL'),
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge($common, $config);
