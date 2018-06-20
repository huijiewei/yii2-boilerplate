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
    'tablePrefix' => getenv('DB_TABLE_PREFIX'),
    'enableSchemaCache' => YII_ENV !== 'dev',
];
