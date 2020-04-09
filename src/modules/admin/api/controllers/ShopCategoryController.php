<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/8/1
 * Time: 18:53
 */

namespace app\modules\admin\api\controllers;

use app\core\models\shop\ShopCategory;
use app\modules\admin\api\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ShopCategoryController extends Controller
{
    public function actionCreate()
    {
        $shopCategory = new ShopCategory();
        $shopCategory->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopCategory->save()) {
            return $shopCategory;
        }

        return $shopCategory;
    }

    public function actionView($id, $withParents = false)
    {
        $shopCategory = $this->getShopCategoryById($id);

        if ($withParents) {
            return $shopCategory->toArray([], ['parents']);
        } else {
            return $shopCategory;
        }
    }

    private function getShopCategoryById($id)
    {
        /* @var $shopCategory ShopCategory */
        $shopCategory = ShopCategory::findOne(['id' => $id]);

        if ($shopCategory == null) {
            throw new NotFoundHttpException('商品分类不存在');
        }

        return $shopCategory;
    }

    public function actionDelete($id)
    {
        $shopCategory = $this->getShopCategoryById($id);

        if (!$shopCategory->delete()) {
            throw new ForbiddenHttpException('分类删除失败');
        }

        return $this->message('商品分类删除成功');
    }

    public function actionEdit($id)
    {
        $shopCategory = $this->getShopCategoryById($id);
        $shopCategory->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopCategory->save()) {
            return $shopCategory;
        }

        return $shopCategory;
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

