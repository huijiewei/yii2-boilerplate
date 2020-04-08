<?php

return [
    'class' => yii\db\Connection::class,
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'tablePrefix' => getenv('DB_TABLE_PREFIX'),
    'enableSchemaCache' => YII_ENV !== 'dev',
];
