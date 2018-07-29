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
use yii\web\BadRequestHttpException;

class UserController extends Controller
{
    public function actionIndex()
    {
        return $this->userSearchForm();
    }

    private function userSearchForm()
    {
        $form = new UserSearchFrom();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionExport()
    {
        $form = $this->userSearchForm();

        $export = $form->export();

        if ($export == null) {
            throw new BadRequestHttpException('不支持导出');
        }

        return $export->send('用户列表.xlsx');
    }

    public function actionCreate()
    {
        return ['userCreate'];
    }
}
