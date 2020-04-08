<?php

namespace app\core\components;

use yii\base\Application;
use yii\base\BootstrapInterface;

abstract class AbstractModuleBootstrap implements BootstrapInterface
{
    /* @var $moduleClass AbstractModule */
    protected $moduleClass;

    /**
     * @param Application $app
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        $this->moduleClass = (new \ReflectionClass(get_called_class()))->getNamespaceName() . '\Module';

        $moduleUrlRules = $this->moduleClass::getUrlRules();

        if ($moduleUrlRules) {
            $app->getUrlManager()->addRules([$moduleUrlRules], true);
        }

        if ($app instanceof \yii\web\Application) {
            $userComponent = $this->moduleClass::getUserComponent();

            if ($userComponent != null) {
                $app->set('user', $userComponent);
            }
        }
    }
}
