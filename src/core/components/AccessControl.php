<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 14:35
 */

namespace app\core\components;

use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{
    /* @var $user User|array|string|bool */
    public $user = 'user';

    public function init()
    {
        parent::init();

        if ($this->user !== false) {
            $this->user = Instance::ensure($this->user, User::class);
        }
    }

    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }

    public function beforeAction($action)
    {
        $actionId = $this->getActionId($action);

        /** @var $identity \app\core\models\Identity */
        $identity = $this->user->getIdentity();

        if (!$identity->can($actionId, \Yii::$app->getRequest()->getMethod())) {
            throw new ForbiddenHttpException('你没有权限进行此操作');
        }

        return true;
    }
}
