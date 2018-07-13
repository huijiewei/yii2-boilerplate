<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:15
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AdminGroupController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => AdminGroup::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);
    }

    public function actionDelete($id)
    {
        /* @var $adminGroup AdminGroup */
        $adminGroup = AdminGroup::findOne(['id' => $id]);

        if ($adminGroup == null) {
            throw new NotFoundHttpException('管理组不存在');
        }

        if (!$adminGroup->delete()) {
            return $adminGroup;
        } else {
            return $this->message('管理组删除成功');
        }
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
            'delete' => ['DELETE'],
        ];
    }
}
