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
    public $disableDebugModule = false;

    abstract public static function getUserComponent();

    public static function getUrlRules()
    {
        return [
            '' => 'site/index',
            '<controller>' => '<controller>/index',
            '<controller>/<action>' => '<controller>/<action>',
        ];
    }

    public static function toRoute($route, $scheme = false)
    {
        if (is_array($route)) {
            $route[0] = '/' . static::getModuleId() . '/' . $route[0];
        } else {
            $route = '/' . static::getModuleId() . '/' . $route;
        }

        return Url::toRoute($route, $scheme);
    }

    abstract public static function getModuleId();

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        if (\Yii::$app instanceof WebApplication) {
            \Yii::$app->getErrorHandler()->errorAction = static::getModuleId() . '/site/error';
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
