<?php

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use yii\web\ForbiddenHttpException;

class ShopProductController extends Controller
{
    public function actionIndex()
    {
        return '暂无内容';
    }

    public function actionExport()
    {
        throw new ForbiddenHttpException('服务暂未实现');
    }
}
