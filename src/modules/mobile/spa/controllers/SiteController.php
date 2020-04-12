<?php

namespace app\modules\mobile\spa\controllers;

use app\modules\admin\spa\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->layout = false;

        return $this->render('/index');
    }

    public function actionError()
    {
        $this->layout = false;

        return $this->render('/error', [
            'exception' => \Yii::$app->getErrorHandler()->exception
        ]);
    }
}
