<?php

namespace app\modules\mobile\api\controllers;

use app\modules\mobile\api\Controller;

class SiteController extends Controller
{
    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }

    public function actionIndex()
    {
        return $this->message('欢迎使用 Boilerplate');
    }
}
