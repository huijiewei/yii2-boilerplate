<?php

namespace app\modules\wechat\controllers;

use app\modules\wechat\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'wechatOpenId' => $this->wechatOpenId,
        ]);
    }

    public function actionError()
    {
        return $this->render('error', [
            'exception' => \Yii::$app->getErrorHandler()->exception
        ]);
    }
}
