<?php

namespace app\core\components;

use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;

class HttpHeaderAuth extends AuthMethod
{
    public $header = 'X-Access-Token';
    public $clientId = '';

    /**
     * @param $user
     * @param $request
     * @param $response
     * @return \yii\web\IdentityInterface|null
     * @throws UnauthorizedHttpException
     */
    public function authenticate($user, $request, $response)
    {
        $token = $request->getHeaders()->get($this->header);

        if (!empty($token)) {
            return $user->loginByAccessToken($token, $this->clientId);
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
