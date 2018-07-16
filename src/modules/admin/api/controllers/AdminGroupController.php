<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:15
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\core\models\admin\AdminGroupAcl;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminGroupController extends Controller
{
    public function actionCreate()
    {
        $adminGroup = new AdminGroup(['id' => 0, 'name' => '']);

        if (!\Yii::$app->getRequest()->getIsPost()) {
            return [
                'adminGroup' => $adminGroup->toArray(['id', 'name'], ['acl']),
                'formRules' => $this->formatModelRules($adminGroup),
                'allAcl' => AdminGroupAcl::getAllAcl()
            ];
        }

        $adminGroup->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$adminGroup->save()) {
            return $adminGroup;
        }

        return $this->message('管理组新建成功');
    }

    public function actionDelete($id)
    {
        $adminGroup = $this->getAdminGroup($id);

        if (!$adminGroup->delete()) {
            return $adminGroup;
        } else {
            return $this->message('管理组删除成功');
        }
    }

    public function actionEdit($id)
    {
        $adminGroup = $this->getAdminGroup($id);

        if (!\Yii::$app->getRequest()->getIsPost()) {
            return [
                'adminGroup' => $adminGroup->toArray(['id', 'name'], ['acl']),
                'formRules' => $this->formatModelRules($adminGroup),
                'allAcl' => AdminGroupAcl::getAllAcl()
            ];
        }

        $adminGroup->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$adminGroup->save()) {
            return $adminGroup;
        }

        return $this->message('管理组编辑成功');
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
        $adminGroup = $this->getAdminGroup($id);

        return $adminGroup->toArray(['id', 'name'], ['acl']);
    }

    private function getAdminGroup($id)
    {
        /* @var $adminGroup AdminGroup */
        $adminGroup = AdminGroup::findOne(['id' => $id]);

        if ($adminGroup == null) {
            throw new NotFoundHttpException('管理组不存在');
        }

        return $adminGroup;
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'create' => ['GET', 'HEAD', 'POST'],
            'view' => ['GET', 'HEAD'],
            'edit' => ['GET', 'HEAD', 'POST'],
            'delete' => ['DELETE'],
        ];
    }
}
