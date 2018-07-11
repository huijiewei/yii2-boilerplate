<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:14
 */

namespace app\core\components\auth;

use yii\filters\auth\AuthMethod;

class HttpHeaderAuth extends AuthMethod
{
    use AuthTrait;

    public $header = 'Access-Token';

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);

        if ($authHeader !== null) {
            $identity = $user->loginByAccessToken($authHeader, '');

            if ($identity === null) {
                $this->challenge($response);
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }
}
