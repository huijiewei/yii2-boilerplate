<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2014/11/3
 * Time: 16:21
 */

/* @var $this \yii\web\View */
/* @var $exception \Exception */
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= '出现错误 - 管理后台 - ' . Yii::$app->name; ?></title>
    <style type="text/css">
        body {
            text-align: center;
            margin-top: 100px;
            color: #647279;
            font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
        }
    </style>
</head>
<body>
<h4>出现错误</h4>
<p><?= $exception->getMessage(); ?></p>
</body>
</html>
