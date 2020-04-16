<?php

namespace app\modules\admin\api\controllers;

use app\core\models\captcha\Captcha;
use app\modules\admin\api\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use huijiewei\upload\ImageCropAction;
use huijiewei\upload\UploadAction;
use yii\web\ForbiddenHttpException;

class OpenController extends Controller
{
    public function actions()
    {
        return [
            'upload-file' => UploadAction::class,
            'crop-image' => ImageCropAction::class,
        ];
    }

    public function actionCaptcha($uuid)
    {
        $captchaBuilder = CaptchaBuilder::create();
        $captchaBuilder->build(100, 30);

        $code = $captchaBuilder->getPhrase();

        $captcha = new Captcha();
        $captcha->uuid = $uuid;
        $captcha->code = $code;
        $captcha->userAgent = \Yii::$app->getRequest()->getUserAgent();
        $captcha->remoteAddr = \Yii::$app->getRequest()->getRemoteIP();
        $captcha->save(false);

        return $captchaBuilder->inline();
    }
}
