<?php

namespace app\modules\admin\api;

use yii\base\Action;

/**
 * Class ControllerAction
 *
 * @property Controller $controller
 * @method run()
 *
 * @package app\modules\admin\api
 */
abstract class ControllerAction extends Action
{
    public function getClientId()
    {
        return $this->controller->getClientId();
    }

    public function message($message, $data = [])
    {
        return $this->controller->message($message, $data);
    }

    public function getIdentity()
    {
        return $this->controller->getIdentity();
    }
}
