<?php

require(__DIR__ . '/../vendor/autoload.php');

(new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__ . '/../.env');

require(__DIR__ . '/../config/env.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$application = new yii\web\Application($config);

$debugUrlRules = false;

if ($debugUrlRules) {
    \yii\helpers\VarDumper::dump($application->getUrlManager()->rules, 10, true);
}

$application->run();
