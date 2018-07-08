<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 09:15
 */

namespace app\core\components\auth;

use yii\web\UnauthorizedHttpException;

trait AuthTrait
{
    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('必须登陆才能进行操作');
    }

    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }
}
