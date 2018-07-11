<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 11:45
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\controllers\auth\LoginAction;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'login' => LoginAction::class
        ];
    }
}
