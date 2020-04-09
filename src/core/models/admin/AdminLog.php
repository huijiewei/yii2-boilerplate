<?php

namespace app\core\models\admin;

use app\core\models\IdentityLog;
use app\core\models\user\User;

/**
 * Class AdminLog
 *
 * @property integer $adminId
 *
 * @property Admin $admin
 *
 * @package app\core\models\admin
 */
class AdminLog extends IdentityLog
{
    public function getAdmin()
    {
        return $this->hasOne(Admin::class, ['id' => 'adminId']);
    }

    public function setOwnerId($ownerId)
    {
        $this->adminId = $ownerId;
    }

    public function extraFields()
    {
        return [
            'admin'
        ];
    }

    public function fields()
    {
        return [
            'id',
            'method',
            'action',
            'params',
            'remoteAddr',
            'userAgent',
            'exception',
            'createdAt' => function ($user) {
                /* @var $user User */
                return \Yii::$app->getFormatter()->asDatetime($user->createdAt);
            },
            'type' => function ($adminLog) {
                /* @var $adminLog AdminLog */
                return $adminLog->getLogType();
            },
            'status' => function ($adminLog) {
                /* @var $adminLog AdminLog */
                return $adminLog->getLogStatus();
            },
        ];
    }
}
