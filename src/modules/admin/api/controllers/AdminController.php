<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:15
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\Admin;
use app\core\models\admin\AdminGroup;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionCreate()
    {
        $admin = new Admin();

        if (!\Yii::$app->getRequest()->getIsPost()) {
            return [
                'admin' => $admin,
                'allGroup' => AdminGroup::find()->orderBy(['id' => SORT_ASC])->all()
            ];
        }

        $admin->setScenario('create');
        $admin->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $this->message('管理员新建成功', ['adminId' => $admin->id]);
    }

    public function actionDelete($id)
    {
        $admin = $this->getAdminById($id);

        if (!$admin->delete()) {
            return $admin;
        } else {
            return $this->message('管理员删除成功');
        }
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

        if (!\Yii::$app->getRequest()->getIsPut()) {
            return [
                'admin' => $admin,
                'allGroup' => AdminGroup::find()->orderBy(['id' => SORT_ASC])->all()
            ];
        }

        $admin->setScenario('edit');
        $admin->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $this->message('管理员编辑成功');
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Admin::find()->with(['group'])->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);
    }

    public function actionView($id)
    {
        $adminGroup = $this->getAdminById($id);

        return $adminGroup->toArray(['id', 'name'], ['acl']);
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'create' => ['GET', 'HEAD', 'POST'],
            'view' => ['GET', 'HEAD'],
            'edit' => ['GET', 'HEAD', 'PUT'],
            'delete' => ['DELETE'],
        ];
    }
}
