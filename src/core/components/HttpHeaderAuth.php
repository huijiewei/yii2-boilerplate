<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 15:11
 */

namespace app\core\components;

use yii\web\UnauthorizedHttpException;

class HttpHeaderAuth extends \yii\filters\auth\HttpHeaderAuth
{
    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }

    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('必须登陆才能进行操作');
    }
}
