<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 15:58
 */

namespace app\modules\admin\api\controllers\auth;

use app\core\models\admin\AdminGroupAcl;
use app\modules\admin\api\ControllerAction;
use app\modules\admin\api\models\AdminLoginForm;

class LoginAction extends ControllerAction
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
    public function run()
    {
        $form = new AdminLoginForm(['clientId' => $this->controller->getClientId()]);

        $form->load(\Yii::$app->getRequest()->post(), '');

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
}
