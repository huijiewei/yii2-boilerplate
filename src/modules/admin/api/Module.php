<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:03
 */

namespace app\modules\admin\api;

use app\core\components\AbstractModule;
use yii\web\Application;

class Module extends AbstractModule
{
    public static function getModuleId()
    {
        return 'admin-api';
    }

    public function init()
    {
        parent::init();

        if (\Yii::$app instanceof Application) {
            $user = \Yii::$app->getUser();
            $user->enableSession = false;
            $user->loginUrl = null;
        }
    }
}
