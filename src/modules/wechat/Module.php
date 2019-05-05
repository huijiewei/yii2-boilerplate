<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

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

    public static function getUrlPrefix()
    {
        return 'wechat';
    }
}
