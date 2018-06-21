<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

namespace app\modules\website;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public static function getModuleId()
    {
        return 'website';
    }

    public static function getUserComponent()
    {
        return null;
    }
}
