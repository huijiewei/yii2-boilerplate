<?php

namespace app\modules\website;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public static function getUserComponent()
    {
        return null;
    }

    public static function getModuleId()
    {
        return 'website';
    }

    public static function getUrlPrefix()
    {
        return '';
    }
}
