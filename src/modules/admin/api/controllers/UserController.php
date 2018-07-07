<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 23:34
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        return ['userIndex'];
    }

    public function actionCreate()
    {
        return ['userCreate'];
    }

}
