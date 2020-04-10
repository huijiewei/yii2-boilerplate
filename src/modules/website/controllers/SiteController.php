<?php

namespace app\modules\website\controllers;

use app\modules\website\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->render('error', [
            'exception' => \Yii::$app->getErrorHandler()->exception
        ]);
    }
}
