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

    public function actionLogout()
    {
        $this->getIdentity()->deleteAccessToken($this->getClientId());

        \Yii::$app->getUser()->logout();

        return $this->message('退出登陆成功');
    }

    public function verbs()
    {
        return [
            'login' => ['POST'],
            'account' => ['GET'],
            'logout' => ['POST'],
        ];
    }
}
