<?php

namespace app\modules\admin\api\controllers;

use app\core\models\admin\Admin;
use app\modules\admin\api\Controller;
use app\modules\admin\api\models\AdminSearchForm;
use Yii;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionCreate()
    {
        $admin = new Admin();
        $admin->setScenario('create');
        $admin->load(Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $admin;
    }

    public function actionDelete($id)
    {
        $admin = $this->getAdminById($id);

        if (!$admin->delete()) {
            return $admin;
        }

        return $this->message('管理员删除成功');
    }

    private function getAdminById($id)
    {
        /* @var $admin Admin */
        $admin = Admin::findOne(['id' => $id]);

        if ($admin == null) {
            throw new NotFoundHttpException('管理员不存在');
        }

        return $admin;
    }

    public function actionEdit($id)
    {
        $admin = $this->getAdminById($id);

        $admin->setScenario('edit');
        $admin->load(Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $admin;
    }

    public function actionIndex()
    {
        $this->addExpandQueryParams('adminGroup');

        $form = new AdminSearchForm();
        $form->load(Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionView($id)
    {
        return $this->getAdminById($id);
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'view' => ['GET'],
            'edit' => ['PUT'],
            'delete' => ['DELETE'],
        ];
    }
}
