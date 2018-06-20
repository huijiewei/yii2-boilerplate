<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

namespace app\modules\admin;

use app\core\components\AbstractModule;

class Module extends AbstractModule
{
    public static function getModuleId()
    {
        return 'admin';
    }

    public function init()
    {
        parent::init();

        /* @var $debug \yii\debug\Module|null */
        $debug = \Yii::$app->getModule('debug');

        if ($debug) {
            $debug->allowedIPs = [];
        }
    }
}
