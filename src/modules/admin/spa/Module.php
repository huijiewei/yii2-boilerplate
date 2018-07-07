<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

namespace app\modules\admin\spa;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public static function getModuleId()
    {
        return 'admin';
    }

    public static function getUserComponent()
    {
        return null;
    }

    public static function getUrlRules()
    {
        return [
            '' => 'site/index',
            '<controller>' => 'site/index',
            '<controller>/<action>' => 'site/index',
        ];
    }

    public $disableDebugModule = true;
}
