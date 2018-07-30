<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:47
 */

namespace app\modules\admin\spa\controllers;

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
