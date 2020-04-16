<?php

namespace app\modules\wechat;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public static function getUserComponent()
    {
        return null;
    }

    public static function getModuleId()
    {
        return 'wechat';
    }
}
