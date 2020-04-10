<?php

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\models\AdminLogSearchFrom;

class AdminLogController extends Controller
{
    public function actionIndex()
    {
        $this->addExpandQueryParams('admin');

        $form = new AdminLogSearchFrom();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }
}
