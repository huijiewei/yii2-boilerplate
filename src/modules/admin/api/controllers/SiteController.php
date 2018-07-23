<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 10:13
 */

namespace app\modules\admin\api\controllers;

use app\extensions\aliyunoss\AliyunOss;
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

    public function actionAliyunOssUpload()
    {
        /* @var $aliyunOss AliyunOss */
        $aliyunOss = \Yii::$app->get('aliyunOss');

        return $aliyunOss->getFormUpload();
    }
}
