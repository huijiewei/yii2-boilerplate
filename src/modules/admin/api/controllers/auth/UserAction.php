<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 16:57
 */

namespace app\modules\admin\api\controllers\auth;

use app\modules\admin\api\ControllerAction;

class UserAction extends ControllerAction
{
    public function run()
    {
        return $this->controller->getIdentity()->toArray(['displayName', 'displayIcon']);
    }
}
