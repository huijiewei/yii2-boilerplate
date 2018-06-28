<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 10:13
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\controllers\site\MenusAction;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'menus' => MenusAction::class,
        ];
    }

    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }
}
