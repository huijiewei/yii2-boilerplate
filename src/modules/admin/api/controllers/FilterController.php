<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/23
 * Time: 15:43
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\core\models\admin\AdminHelper;
use app\modules\admin\api\Controller;

class FilterController extends Controller
{
    public function actionAdminGroups()
    {
        return AdminGroup::find()->select(['id', 'name'])->orderBy(['id' => SORT_ASC])->all();
    }

    public function actionAdminAllAcl()
    {
        return AdminHelper::getAllAcl();
    }
}
