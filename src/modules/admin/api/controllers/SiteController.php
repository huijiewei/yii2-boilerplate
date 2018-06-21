<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 10:13
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use Symfony\Component\VarDumper\VarDumper;

class SiteController extends Controller
{
    public function actionError()
    {
        VarDumper::dump(\Yii::$app->getErrorHandler()->exception);

        return \Yii::$app->getErrorHandler()->exception;
    }
}
