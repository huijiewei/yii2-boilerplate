<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:14
 */

namespace app\core\components;

use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

class HttpHeaderAuth extends AuthMethod
{
    public $header = 'X-Access-Token';
    public $clientId = '';

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);

        if ($authHeader !== null) {
            $identity = $user->loginByAccessToken($authHeader, $this->clientId);

            if ($identity === null) {
                $this->challenge($response);
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }

    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('必须登陆才能进行操作');
    }

    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }
}
