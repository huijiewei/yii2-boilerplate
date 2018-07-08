<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/8
 * Time: 11:05
 */

namespace app\modules\admin;

use app\core\components\AbstractModuleBootstrap;
use app\modules\admin\api\ModuleBootstrap as ApiModuleBootstrap;
use app\modules\admin\spa\ModuleBootstrap as SpaModuleBootstrap;

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
