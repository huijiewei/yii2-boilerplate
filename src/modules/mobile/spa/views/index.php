<?php

/* @var $this \yii\web\View */

\app\modules\mobile\spa\ManifestAssetBundle::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="api-host" content="<?= \app\modules\admin\api\Module::toRoute([''], true); ?>">
        <title><?= '管理后台 - ' . Yii::$app->name; ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            body {
                padding: 0;
                margin: 0;
            }

            #spinner {
                position: absolute;
                width: 100%;
                z-index: 19811223;
                display: flex;
                height: 100%;
                min-height: 100vh;
                justify-content: center;
                align-items: center;
                background: #fff;
            }

            .spinner {
                margin: 0 auto;
                width: 50px;
                height: 40px;
                font-size: 10px;
            }

            .spinner > div {
                background-color: #666;
                height: 100%;
                width: 6px;
                display: inline-block;

                -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
                animation: sk-stretchdelay 1.2s infinite ease-in-out;
            }

            .spinner .rect2 {
                -webkit-animation-delay: -1.1s;
                animation-delay: -1.1s;
            }

            .spinner .rect3 {
                -webkit-animation-delay: -1.0s;
                animation-delay: -1.0s;
            }

            .spinner .rect4 {
                -webkit-animation-delay: -0.9s;
                animation-delay: -0.9s;
            }

            .spinner .rect5 {
                -webkit-animation-delay: -0.8s;
                animation-delay: -0.8s;
            }

            @-webkit-keyframes sk-stretchdelay {
                0%, 40%, 100% {
                    -webkit-transform: scaleY(0.4)
                }
                20% {
                    -webkit-transform: scaleY(1.0)
                }
            }

            @keyframes sk-stretchdelay {
                0%, 40%, 100% {
                    transform: scaleY(0.4);
                    -webkit-transform: scaleY(0.4);
                }
                20% {
                    transform: scaleY(1.0);
                    -webkit-transform: scaleY(1.0);
                }
            }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="spinner">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
    <div id="root"></div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
