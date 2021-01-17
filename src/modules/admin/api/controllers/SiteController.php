<?php

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;

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
