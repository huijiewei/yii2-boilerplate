<?php

namespace app\modules\mobile;

use app\core\components\AbstractModuleBootstrap;
use app\modules\mobile\api\ModuleBootstrap as ApiModuleBootstrap;
use app\modules\mobile\spa\ModuleBootstrap as SpaModuleBootstrap;

class ModuleBootstrap extends AbstractModuleBootstrap
{
    public function bootstrap($app)
    {
        $api = new ApiModuleBootstrap();

        $api->bootstrap($app);

        $spa = new SpaModuleBootstrap();

        $spa->bootstrap($app);

        parent::bootstrap($app);
    }
}
