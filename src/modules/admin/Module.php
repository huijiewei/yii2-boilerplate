<?php

namespace app\modules\admin;

use app\core\components\AbstractModule;
use app\modules\admin\api\Module as ApiModule;
use app\modules\admin\spa\Module as SpaModule;

class Module extends AbstractModule
{
    public static function getUserComponent()
    {
        return null;
    }

    public static function getModuleId()
    {
        return 'admin';
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
