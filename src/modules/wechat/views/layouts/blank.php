<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2014/11/3
 * Time: 16:21
 */

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \app\modules\wechat\Controller */

$context = $this->context;
?>
<?php $this->beginContent('@app/modules/wechat/views/layouts/base.php'); ?>
    <div class="container">
        <?= $content; ?>
    </div>
<?php $this->endContent();
