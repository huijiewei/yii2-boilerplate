<?php

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use huijiewei\upload\ImageCropAction;
use huijiewei\upload\UploadAction;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'upload-file' => UploadAction::class,
            'crop-image' => ImageCropAction::class,
        ];
    }

    public function actionError()
    {
        return \Yii::$app->getErrorHandler()->exception;
    }

    public function actionIndex()
    {
        return $this->message('欢迎使用 Boilerplate');
    }
}
