<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 15:44
 */

return [
    'class' => yii\db\Connection::class,
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'tablePrefix' => 'bp_', //@todo 修改数据表前缀
    'enableSchemaCache' => YII_ENV !== 'dev',
];
