<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 19:59
 */

namespace app\core\components;

use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

abstract class AbstractModule extends \yii\base\Module
{
    abstract public static function getModuleId();

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        if (\Yii::$app instanceof WebApplication) {
            \Yii::$app->getErrorHandler()->errorAction = $this->id . '/site/error';
        }

        if (\Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = (new \ReflectionClass(get_called_class()))->getNamespaceName() . '\commands';
        }
    }
}
