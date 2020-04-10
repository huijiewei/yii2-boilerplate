<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \app\modules\website\Controller */

$context = $this->context;
?>
<?php $this->beginContent('@app/modules/website/views/layouts/base.php'); ?>
    <div class="container">
        <?= $content; ?>
    </div>
<?php $this->endContent();
