<?php

namespace app\modules\mobile\spa;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public $disableDebugModule = true;

    public static function getModuleId()
    {
        return 'spa';
    }

    public static function getUrlPrefix()
    {
        return 'mobile';
    }

    public static function getRoutePrefix()
    {
        return 'mobile/spa';
    }

    public static function getUserComponent()
    {
        return null;
    }

    public static function getRouteRules()
    {
        return [
            '' => 'site/index',
            '<url:(.*)>' => 'site/index',
        ];
    }
}
