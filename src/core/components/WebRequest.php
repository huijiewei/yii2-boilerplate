<?php

namespace app\core\components;

class WebRequest extends \yii\web\Request
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
