<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2014/11/9
 * Time: 11:32
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $context \app\modules\website\WebController */
/* @var $exception \Exception */

$context = $this->context;

$context->layout = 'blank';
?>
<?php
if ($exception instanceof \yii\web\UnauthorizedHttpException) {
    $this->title = '登录';
    \app\core\widgets\ScriptBlock::begin(); ?>
    <script>
        $(document).ready(function() {
            $.loginModal('<?= Html::encode(Yii::$app->getRequest()->getUrl()); ?>')
        })
    </script>
    <?php \app\core\widgets\ScriptBlock::end();
} else {
    $this->title = '出现错误'; ?>
    <div class="center-wrap">
        <hr class="spacer-sm">
        <hr class="spacer-sm">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-title"><?= $this->title; ?></div>
            </div>
            <div class="panel-body">
                <h2><?= $exception->getMessage(); ?></h2>
            </div>
            <div class="panel-footer">
                <a class="btn btn-info btn-lg" href="<?= $context->getBackUrl(); ?>">点击返回</a>
            </div>
        </div>
    </div>
    <?php
}
