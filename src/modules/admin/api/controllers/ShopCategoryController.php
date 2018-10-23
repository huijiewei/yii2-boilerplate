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
use yii\web\NotFoundHttpException;

class ShopCategoryController extends Controller
{
    public function actionCreate($parentId = 0)
    {
        $shopCategory = new ShopCategory();

        if (!\Yii::$app->getRequest()->getIsPost()) {
            $shopCategory->parentId = $parentId;
            return $shopCategory->toArray(['*'], ['ancestor']);
        }

        $shopCategory->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopCategory->save()) {
            return $shopCategory;
        }

        return $this->message('商品分类新建成功', ['categoryId' => $shopCategory->id]);
    }

    public function actionEdit($id)
    {
        $shopCategory = $this->getShopCategoryById($id);

        if (!\Yii::$app->getRequest()->getIsPut()) {
            return $shopCategory->toArray(['*'], ['ancestor']);
        }

        $shopCategory->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopCategory->save()) {
            return $shopCategory;
        }

        return $this->message('商品分类编辑成功');
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

}
