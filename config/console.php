<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 15:50
 */

$common = require(__DIR__ . '/common.php');

$config = [
    'id' => 'bp-console',
    'name' => '样板项目控制台应用',

    'components' => [
        'urlManager' => [
            'baseUrl' => getenv('APP_URL'),
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge($common, $config);
