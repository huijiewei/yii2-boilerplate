<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 19:59
 */

namespace app\core\components;

use yii\console\Application as ConsoleApplication;
use yii\helpers\Url;
use yii\web\Application as WebApplication;

abstract class AbstractModule extends \yii\base\Module
{
    abstract public static function getModuleId();

    abstract public static function getUserComponent();

    public static function toRoute($route, $scheme = false)
    {
        if (is_array($route)) {
            $route[0] = '/' . static::getModuleId() . '/' . $route[0];
        } else {
            $route = '/' . static::getModuleId() . '/' . $route;
        }

        return Url::toRoute($route, $scheme);
    }

    public $disableDebugModule = false;

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        if (\Yii::$app instanceof WebApplication) {
            \Yii::$app->getErrorHandler()->errorAction = $this->id . '/site/error';
        }

        if (\Yii::$app instanceof ConsoleApplication) {
            $namespace = (new \ReflectionClass(get_called_class()))->getNamespaceName();
            $this->controllerNamespace = $namespace . '\\commands';
        }

        if ($this->disableDebugModule) {
            /* @var $debug \yii\debug\Module|null */
            $debug = \Yii::$app->getModule('debug');

            if ($debug) {
                $debug->allowedIPs = [];
            }
        }
    }
}
