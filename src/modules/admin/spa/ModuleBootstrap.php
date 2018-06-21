<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 08:43
 */

namespace app\modules\admin\spa;

use app\core\components\AbstractModuleBootstrap;
use yii\web\GroupUrlRule;

class ModuleBootstrap extends AbstractModuleBootstrap
{
    protected function getUrlRules()
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => $this->getModuleId(),
                'rules' => [
                    '' => 'site/index',
                    '<controller>' => 'site/index',
                    '<controller>/<action>' => 'site/index',
                ],
            ]
        ];
    }
}
