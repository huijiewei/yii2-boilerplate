<?php

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\models\AdminLoginForm;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $form = new AdminLoginForm(['clientId' => $this->getClientId()]);

        $form->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $form->remoteAddr = \Yii::$app->getRequest()->getRemoteIP();
        $form->userAgent = \Yii::$app->getRequest()->getUserAgent();

        if (!$form->login()) {
            return $form;
        }

        $account = $this->actionAccount();
        $account['accessToken'] = $form->accessToken->accessToken;

        return $this->message('登陆成功', $account);
    }

    public function actionAccount()
    {
        return [
            'currentUser' => $this->getIdentity()->toArray([], ['adminGroup']),
            'groupMenus' => $this->getIdentity()->getGroupMenus(),
            'groupPermissions' => $this->getIdentity()->getGroupPermissions(),
        ];
    }

    public function actionProfile()
    {
        $profile = $this->getIdentity();

        if (\Yii::$app->getRequest()->getIsPut()) {
            $profile->setScenario('profile');
            $profile->load(\Yii::$app->getRequest()->getBodyParams(), '');

            if (!$profile->save()) {
                return $profile;
            }

            return $profile;
        }

        return $profile;
    }

    public function actionLogout()
    {
        $this->getIdentity()->logout(
            $this->getClientId(),
            \Yii::$app->getRequest()->getRemoteIP(),
            \Yii::$app->getRequest()->getUserAgent()
        );

        \Yii::$app->getUser()->logout();

        return $this->message('退出登陆成功');
    }

    public function verbs()
    {
        return [
            'login' => ['POST'],
            'account' => ['GET'],
            'profile' => ['GET', 'PUT'],
            'logout' => ['POST'],
        ];
    }
}
