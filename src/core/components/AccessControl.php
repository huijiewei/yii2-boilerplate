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

        $log = $identity->createLog();

        if ($log != null) {
            $log->type = \Yii::$app->getRequest()->getIsGet() ?
                IdentityLog::TYPE_VISIT : IdentityLog::TYPE_OPERATE;
            $log->remoteAddr = \Yii::$app->getRequest()->getRemoteIP();
            $log->userAgent = \Yii::$app->getRequest()->getUserAgent();
            $log->method = \Yii::$app->getRequest()->getMethod();
            $log->action = $actionId;
            $log->params = http_build_query(\Yii::$app->getRequest()->getQueryParams());
        }

        if (!$identity->can($actionId)) {
            if ($log != null) {
                $log->status = IdentityLog::STATUS_FAIL;
                $log->save(false);
            }

            throw new ForbiddenHttpException('你没有权限进行此操作');
        }

        if ($log != null) {
            $log->status = IdentityLog::STATUS_SUCCESS;
            $log->save(false);
        }

        return true;
    }

    protected function getActionId($action)
    {
        return $action->controller->id . '/' . $action->id;
    }
}
