<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/25
 * Time: 22:17
 */

namespace app\core\models\user;

use app\core\models\Identity;

/**
 * Class User
 *
 * @property string $phone
 * @property string $display
 * @property string $avatar
 * @property string $createdIp
 * @property string $createdFrom
 *
 * @package app\core\models\user
 */
class User extends Identity
{
    const CREATED_FROM_SYSTEM = 'SYSTEM';
    const CREATED_FROM_WEB = 'WEB';
    const CREATED_FROM_APP = 'APP';
    const CREATED_FROM_WECHAT = 'WECHAT';

    public static function findByAccessToken($token, $clientId)
    {
        return null;
    }

    public function getCreatedFromName()
    {
        return User::getCreatedFromNameByFrom($this->createdFrom);
    }

    public static function getCreatedFromNameByFrom($from)
    {
        $list = User::createdFromNameList();

        return isset($list[$from]) ? $list[$from] : $from;
    }

    public static function createdFromNameList()
    {
        return [
            static::CREATED_FROM_SYSTEM => '系统',
            static::CREATED_FROM_WEB => '网站',
            static::CREATED_FROM_APP => 'APP',
            static::CREATED_FROM_WECHAT => '微信',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'phone',
            'display',
            'avatar',
            'createdAt' => function ($user) {
                return \Yii::$app->getFormatter()->asDatetime($user->createdAt);
            },
            'createdIp',
            'createdFrom',
            'createdFromName'
        ];
    }

    public function can($actionId)
    {
        return true;
    }

    public function generateAccessToken($clientId = '')
    {
        return '';
    }
}
