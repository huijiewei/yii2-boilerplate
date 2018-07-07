<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 08:53
 */

namespace app\core\components;

use yii\base\Application;
use yii\base\BootstrapInterface;

abstract class AbstractModuleBootstrap implements BootstrapInterface
{
    public $appendUrlRules = true;

    /**
     * @return static
     */
    protected function getModuleId()
    {
        return $this->moduleClass::getModuleId();
    }

    /* @var $moduleClass AbstractModule */
    protected $moduleClass;

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $this->moduleClass = (new \ReflectionClass(get_called_class()))->getNamespaceName() . '\Module';

        if ($this->appendUrlRules) {
            $app->getUrlManager()->addRules($this->moduleClass::getUrlRules(), false);
        }

        if ($app instanceof \yii\web\Application) {
            $userComponent = $this->moduleClass::getUserComponent();

            if ($userComponent != null) {
                $app->set('user', $userComponent);
            }
        }
    }
}
