<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 10:13
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;

class SiteController extends Controller
{
    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }

    public function actionMenus()
    {
        if ($this->getIdentity() == null) {
            return [];
        }


        return [];
    }
}
