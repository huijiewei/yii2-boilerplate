<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 18:07
 */

namespace app\modules\website\controllers;

use app\modules\website\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        return $this->render('login');
    }
}
