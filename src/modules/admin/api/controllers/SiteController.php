<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 10:13
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use huijiewei\upload\BaseUpload;
use huijiewei\upload\UploadAction;

class SiteController extends Controller
{
    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }

    public function actionIndex()
    {
        return $this->message('欢迎使用 Boilerplate');
    }

    public function actionUploadAvatarOptions()
    {
        /* @var $upload BaseUpload */
        $upload = \Yii::$app->get('upload');

        return $upload->build(1024 * 1024, ['gif', 'png', 'jpg', 'jpeg']);
    }

    public function actions()
    {
        return [
            'upload' => UploadAction::class,
        ];
    }
}
