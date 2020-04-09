<?php

namespace app\core\components;

use app\core\models\IdentityLog;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class AccessControl extends ActionFilter
{
    /* @var $user User|array|string|bool */
    public $user = 'user';

    /* @var $log IdentityLog|null */
    private $log;

    public function init()
    {
        parent::init();

        if ($this->user !== false) {
            $this->user = Instance::ensure($this->user, User::class);
        }
    }

    public function beforeAction($action)
    {
        $actionId = $this->getActionId($action);

        /** @var $identity \app\core\models\Identity */
        $identity = $this->user->getIdentity();

        $this->log = $identity->createLog();

        if ($this->log != null) {
            $this->log->type = \Yii::$app->getRequest()->getIsGet() ?
                IdentityLog::TYPE_VISIT : IdentityLog::TYPE_OPERATE;
            $this->log->remoteAddr = \Yii::$app->getRequest()->getRemoteIP();
            $this->log->userAgent = \Yii::$app->getRequest()->getUserAgent();
            $this->log->method = \Yii::$app->getRequest()->getMethod();
            $this->log->action = $actionId;
            $this->log->params = \Yii::$app->getRequest()->getQueryString();
        }

        if (!$identity->can($actionId)) {
            if ($this->log != null) {
                $this->log->status = IdentityLog::STATUS_FAIL;
                $this->log->save(false);
            }

            throw new ForbiddenHttpException('你没有权限进行此操作');
        }

        if ($this->log != null) {
            $this->log->status = IdentityLog::STATUS_SUCCESS;
            $this->log->save(false);
        }

        return true;
    }

    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }
}
