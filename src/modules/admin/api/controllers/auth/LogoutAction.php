<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 16:41
 */

namespace app\modules\admin\api\controllers\auth;

use app\core\models\admin\AdminAccessToken;
use app\modules\admin\api\ControllerAction;

class LogoutAction extends ControllerAction
{
    public function run()
    {
        AdminAccessToken::deleteAccessToken($this->controller->getIdentity()->id, $this->controller->getClientId());

        return ['success' => true, 'message' => '退出登陆成功'];
    }
}
