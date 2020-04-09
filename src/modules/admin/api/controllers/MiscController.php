<?php

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\core\models\admin\AdminHelper;
use app\core\models\shop\ShopCategory;
use app\modules\admin\api\Controller;
use huijiewei\upload\BaseUpload;

class MiscController extends Controller
{
    public function actionAdminGroupList()
    {
        return AdminGroup::find()->select(['id', 'name'])->orderBy(['id' => SORT_ASC])->all();
    }

    public function actionAdminGroupAcl()
    {
        return AdminHelper::getAllPermissions();
    }

    public function actionShopCategoryTree()
    {
        return ShopCategory::getTree();
    }

    public function actionShopCategoryPath($id)
    {
        return ShopCategory::getParentsById($id);
    }

    public function actionImageUploadOption()
    {
        /* @var $upload BaseUpload */
        $upload = \Yii::$app->get('upload');

        return $upload->build(
            'a' . $this->getIdentity()->id,
            1024 * 1024 * 2,
            ['jpg', 'jpeg', 'png', 'gif'],
            \Yii::$app->getRequest()->getQueryParam('thumbs', null),
            \Yii::$app->getRequest()->getQueryParam('cropper', false)
        );
    }

    public function actionFileUploadOption()
    {
        /* @var $upload BaseUpload */
        $upload = \Yii::$app->get('upload');

        return $upload->build(
            'a' . $this->getIdentity()->id,
            1024 * 1024 * 10,
            ['jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', 'docx', 'pptx', 'xlsx', 'pdf']
        );
    }
}
