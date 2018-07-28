<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 23:34
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\models\UserSearchFrom;

class UserController extends Controller
{
    public function actionIndex()
    {
        $form = new UserSearchFrom();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionCreate()
    {
        return ['userCreate'];
    }
}
