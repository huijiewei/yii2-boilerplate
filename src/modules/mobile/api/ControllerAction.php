<?php

namespace app\modules\mobile\api;

use yii\base\Action;

/**
 * Class ControllerAction
 *
 * @property Controller $controller
 * @method run()
 *
 * @package app\modules\mobile\api
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
