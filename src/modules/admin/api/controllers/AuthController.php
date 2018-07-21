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
    /**
     * @SWG\Post(path="/auth/login",
     *   tags={"auth"},
     *   summary="管理员登陆",
     *   description="管理员登陆接口",
     *   operationId="login",
     *   @SWG\Parameter(
     *     in="body",
     *     name="admin",
     *     description="登陆信息",
     *     required=true,
     *     @SWG\Schema(
     *      @SWG\Property(
     *         property="account",
     *         type="string",
     *      ),
     *      @SWG\Property(
     *         property="password",
     *         type="string",
     *      )
     *    )
     *   ),
     *   @SWG\Response(response="default", description="成功后会返回一个 accessToken，保存到本地，然后每次请求头里面带上 X-Access-Token")
     * )
     */
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
     * @return string
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
