<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2014/11/3
 * Time: 16:21
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \app\modules\admin\spa\Controller */

$context = $this->context;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= '后台' . ' - ' . Yii::$app->name; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $content; ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
