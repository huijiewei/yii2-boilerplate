<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

namespace app\modules\admin\spa;

use app\core\components\AbstractModule;
use yii\web\Application;

class Module extends AbstractModule
{
    public $disableDebugModule = true;

    public static function getModuleId()
    {
        return 'spa';
    }

    public static function getUrlPrefix()
    {
        return 'admin';
    }

    public static function getRoutePrefix()
    {
        return 'admin/spa';
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
