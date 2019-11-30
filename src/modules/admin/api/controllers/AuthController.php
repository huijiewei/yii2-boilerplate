<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 11:45
 */

namespace app\modules\admin\api\controllers;

use app\modules\admin\api\Controller;
use app\modules\admin\api\models\AdminLoginForm;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $form = new AdminLoginForm(['clientId' => $this->getClientId()]);

        $form->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$form->login()) {
            return $form;
        }

        return $this->message('登陆成功', [
            'accessToken' => $form->accessToken->token,
            'currentUser' => $this->actionCurrentUser(),
            'groupAcl' => $this->actionGroupAcl(),
            'groupMenus' => $this->actionGroupMenus(),
        ]);
    }

    public function actionCurrentUser()
    {
        return $this->getIdentity();
    }

    public function actionGroupAcl()
    {
        return $this->getIdentity()->getGroupAcl();
    }

    public function actionGroupMenus()
    {
        return $this->getIdentity()->getGroupMenus();
    }

    public function actionAuthentication()
    {
        return [
            'currentUser' => $this->actionCurrentUser(),
            'groupAcl' => $this->actionGroupAcl(),
            'groupMenus' => $this->actionGroupMenus(),
        ];
    }

    /**
     * @return array
     */
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
            'user' => ['GET'],
            'logout' => ['POST'],
        ];
    }
}
