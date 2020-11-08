<?php

namespace app\modules\admin\api\controllers;

use app\core\helpers\StringHelper;
use app\core\models\captcha\Captcha;
use app\modules\admin\api\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use huijiewei\upload\ImageCropAction;
use huijiewei\upload\UploadAction;

class OpenController extends Controller
{
    public function actions()
    {
        return [
            'upload-file' => UploadAction::class,
            'crop-image' => ImageCropAction::class,
        ];
    }

    public function actionCaptcha()
    {
        $captchaBuilder = CaptchaBuilder::create();
        $captchaBuilder->build(100, 30);

        $code = $captchaBuilder->getPhrase();
        $uuid = StringHelper::generateNanoId(16);

        $captcha = new Captcha();
        $captcha->uuid = $uuid;
        $captcha->code = $code;
        $captcha->userAgent = \Yii::$app->getRequest()->getUserAgent();
        $captcha->remoteAddr = \Yii::$app->getRequest()->getRemoteIP();
        $captcha->save(false);

        return [
            'image' => $captchaBuilder->inline(),
            'process' => 'return captcha + "_' . $uuid . '"'
        ];
    }
}
