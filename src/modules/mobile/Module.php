<?php

namespace app\modules\mobile;

use app\core\components\AbstractModule;
use app\modules\mobile\api\Module as ApiModule;
use app\modules\mobile\spa\Module as SpaModule;

class Module extends AbstractModule
{
    public static function getUserComponent()
    {
        return null;
    }

    public static function getModuleId()
    {
        return 'mobile';
    }

    public static function getUrlRules()
    {
        return null;
    }

    public function init()
    {
        parent::init();

        $this->modules = [
            ApiModule::getModuleId() => ApiModule::class,
            SpaModule::getModuleId() => SpaModule::class,
        ];
    }
}
