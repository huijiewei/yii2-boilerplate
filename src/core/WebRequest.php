<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:50
 */

namespace app\core;

use yii\web\Request;

class WebRequest extends Request
{
    /**
     * @return string
     */
    public function getUserIP()
    {
        return parent::getUserIP() ?? '';
    }

    /**
     * @return string
     */
    public function getUserHost()
    {
        return parent::getUserHost() ?? '';
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return parent::getUserAgent() ?? '';
    }

    /**
     * @return string
     */
    public function getReferrer()
    {
        return parent::getReferrer() ?? '';
    }
}
