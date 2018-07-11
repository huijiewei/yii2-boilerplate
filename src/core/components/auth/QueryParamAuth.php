<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:18
 */

namespace app\core\components\auth;

use yii\filters\auth\AuthMethod;

class QueryParamAuth extends AuthMethod
{
    use AuthTrait;

    public $tokenParam = 'access-token';

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response)
    {
        $accessToken = $request->get($this->tokenParam);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, '');
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
}
