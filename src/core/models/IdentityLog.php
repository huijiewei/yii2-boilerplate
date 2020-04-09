<?php

namespace app\core\models;

use app\core\components\ActiveRecord;

/**
 * Class IdentityLog
 *
 * @property integer $id
 * @property integer $status
 * @property string $type
 * @property string $method
 * @property string $action
 * @property string $params
 * @property string $remoteAddr
 * @property string $userAgent
 * @property string $exception
 * @property string $createdAt
 *
 * @package app\core\models
 */
class IdentityLog extends ActiveRecord
{
    public const TYPE_LOGIN = "LOGIN";
    public const TYPE_VISIT = "VISIT";
    public const TYPE_OPERATE = "OPERATE";

    public const STATUS_FAIL = 0;
    public const STATUS_SUCCESS = 1;

    private $logTypeCache = null;
    private $logStatusCache = null;

    /**
     * @return IdentityLogType
     */
    public function getLogType()
    {
        if ($this->logTypeCache == null) {
            $logType = new IdentityLogType('', '未知');

            foreach (static::typeList() as $item) {
                if ($item->value == $this->type) {
                    $logType = $item;
                    break;
                }
            }

            $this->logTypeCache = $logType;
        }

        return $this->logTypeCache;
    }

    public static function typeList()
    {
        return [
            new IdentityLogType(static::TYPE_LOGIN, '登录'),
            new IdentityLogType(static::TYPE_VISIT, '访问'),
            new IdentityLogType(static::TYPE_OPERATE, '操作'),
        ];
    }

    /**
     * @return IdentityLogStatus
     */
    public function getLogStatus()
    {
        if ($this->logStatusCache == null) {
            $logStatus = new IdentityLogStatus('', '未知');

            foreach (static::statusList() as $item) {
                if ($item->value == $this->status) {
                    $logStatus = $item;
                    break;
                }
            }

            $this->logStatusCache = $logStatus;
        }

        return $this->logStatusCache;
    }

    public static function statusList()
    {
        return [
            new IdentityLogStatus(static::STATUS_FAIL, '失败'),
            new IdentityLogStatus(static::STATUS_SUCCESS, '成功'),
        ];
    }
}
