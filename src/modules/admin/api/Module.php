<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:03
 */

namespace app\modules\admin\api;

use app\core\components\AbstractModule;
use app\core\models\admin\Admin;
use yii\web\User;

class Module extends AbstractModule
{
    public $disableDebugModule = true;

    public static function getModuleId()
    {
        return 'admin-api';
    }

    public static function getUrlRules()
    {
        return [
            'site/<action\w+>' => 'site/<action>',
            'GET <controller:\w+>s' => '<controller>/index',
            'POST <controller:\w+>s' => '<controller>/create',
            'GET <controller:\w+>s/<id:\d+>' => '<controller>/view',
            'PUT <controller:\w+>s/<id:\d+>' => '<controller>/update',
            'DELETE <controller:\w+>s/<id:\d+>' => '<controller>/delete',
            'GET <controller:\w+>s/search' => '<controller>/search',
        ];
    }

    public static function getUserComponent()
    {
        return [
            'class' => User::class,
            'identityClass' => Admin::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ];
    }
}
