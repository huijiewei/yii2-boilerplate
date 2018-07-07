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

    public static function getUrlRules()
    {
        return [
            [
                '' => static::getModuleId() . '/site/index',
                '<controller>' => static::getModuleId() . '/<controller>/index',
                '<controller>/<action>' => static::getModuleId() . '/<controller>/<action>',
            ]
        ];
    }
}
