<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:47
 */

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
