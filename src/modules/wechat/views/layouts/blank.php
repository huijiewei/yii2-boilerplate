<?php

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
