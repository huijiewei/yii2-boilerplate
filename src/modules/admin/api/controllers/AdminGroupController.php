<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:15
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\controllers\adminGroup\IndexAction;

class AdminGroupController extends Controller
{
    public function actions()
    {
        return [
            'index' => IndexAction::class
        ];
    }
}
