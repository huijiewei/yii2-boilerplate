<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 19:59
 */

namespace app\core\components;

abstract class AbstractModule extends \yii\base\Module
{
    abstract public static function getModuleId();

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        \Yii::$app->getErrorHandler()->errorAction = $this->id . '/site/error';
    }
}
