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
use yii\web\GroupUrlRule;

abstract class AbstractModuleBootstrap implements BootstrapInterface
{
    /**
     * @return static
     */
    protected function getModuleId()
    {
        return $this->moduleClass::getModuleId();
    }

    protected function getUrlRules()
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => $this->getModuleId(),
                'rules' => [
                    '' => 'site/index',
                    '<controller>' => '<controller>/index',
                    '<controller>/<action>' => '<controller>/<action>',
                ],
            ]
        ];
    }

    protected function getUserComponent()
    {
        return $this->moduleClass::getUserComponent();
    }

    /* @var $moduleClass AbstractModule */
    protected $moduleClass;

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $this->moduleClass = (new \ReflectionClass(get_called_class()))->getNamespaceName() . '\Module';

        $app->getUrlManager()->addRules($this->getUrlRules(), false);

        if ($app instanceof \yii\web\Application) {
            $userComponent = $this->getUserComponent();

            if ($userComponent != null) {
                $app->set('user', $userComponent);
            }
        }
    }
}
