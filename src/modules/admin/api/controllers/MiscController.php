<?php

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\core\models\admin\AdminHelper;
use app\core\models\shop\ShopCategory;
use app\modules\admin\api\Controller;

class MiscController extends Controller
{
    public function actionAdminGroupList()
    {
        return AdminGroup::find()->select(['id', 'name'])->orderBy(['id' => SORT_ASC])->all();
    }

    public function actionAdminGroupAcl()
    {
        return AdminHelper::getAllPermissions();
    }

    public function actionShopCategoryTree()
    {
        return ShopCategory::getTree();
    }
}
