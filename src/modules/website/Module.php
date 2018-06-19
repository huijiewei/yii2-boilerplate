<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:46
 */

namespace app\modules\website;

use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

class Module extends BaseModule implements BootstrapInterface
{
    public function init()
    {
        parent::init();

        $this->layout = 'main';
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            '' => $this->id . '/site/index',
            '<controller:[\w\-]+>' => $this->id . '/<controller>/index',
            '<controller:[\w\-]+>/<action:[\w\-]+>' => $this->id . '/<controller>/<action>',
        ], false);
    }
}
