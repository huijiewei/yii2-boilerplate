<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 11:45
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminAccessToken;
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

        return [
            'success' => true,
            'message' => '登陆成功',
            'user' => $form->admin->toArray(['displayName', 'displayIcon'], ['groupAcl']),
            'accessToken' => $form->accessToken->token,
        ];
    }

    /**
     * @return array
     */
    public function actionUser()
    {
        return $this->getIdentity()->toArray(['displayName', 'displayIcon'], ['groupAcl']);
    }

    /**
     * @return string
     */
    public function actionLogout()
    {
        AdminAccessToken::deleteAccessToken($this->getIdentity()->id, $this->getClientId());

        return '退出登陆成功';
    }
}
