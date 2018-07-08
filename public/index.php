<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 15:39
 */

require(__DIR__ . '/../vendor/autoload.php');

(new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__ . '/../.env');

require(__DIR__ . '/../config/env.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$application = new yii\web\Application($config);

$debugUrlRules = false;

if ($debugUrlRules) {
    \Symfony\Component\VarDumper\VarDumper::dump($application->getUrlManager()->rules);
    die;
}

$application->run();
