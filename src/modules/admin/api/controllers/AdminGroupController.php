<?php

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminGroupController extends Controller
{
    public function actionCreate()
    {
        $adminGroup = new AdminGroup();
        $adminGroup->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$adminGroup->save()) {
            return $adminGroup;
        }

        return $adminGroup;
    }

    public function actionDelete($id)
    {
        $adminGroup = $this->getAdminGroupById($id);

        if (!$adminGroup->delete()) {
            return $adminGroup;
        }

        return $this->message('管理组删除成功');
    }

    private function getAdminGroupById($id)
    {
        /* @var $adminGroup AdminGroup */
        $adminGroup = AdminGroup::findOne(['id' => $id]);

        if ($adminGroup == null) {
            throw new NotFoundHttpException('管理组不存在');
        }

        return $adminGroup;
    }

    public function actionEdit($id)
    {
        $adminGroup = $this->getAdminGroupById($id);
        $adminGroup->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$adminGroup->save()) {
            return $adminGroup;
        }

        return $adminGroup;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => AdminGroup::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);
    }

    public function actionView($id)
    {
        $adminGroup = $this->getAdminGroupById($id);

        return $adminGroup->toArray([], ['permissions']);
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
