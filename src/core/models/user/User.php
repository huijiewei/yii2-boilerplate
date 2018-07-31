<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/25
 * Time: 22:17
 */

namespace app\core\models\user;

use app\core\models\Identity;
use app\core\validators\PhoneNumberValidator;

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

    public function rules()
    {
        return [
            [['phone', 'display', 'avatar', 'password', 'passwordRepeat'], 'trim'],
            [['password', 'passwordRepeat'], 'required', 'on' => 'create'],
            [
                ['password', 'passwordRepeat'],
                'string',
                'length' => [5, 20],
                'on' => 'create',
                'when' => function ($model) {
                    return !empty($model->passwordRepeat);
                }
            ],
            ['password', 'compare', 'compareAttribute' => 'passwordRepeat'],
            ['phone', 'required'],
            ['phone', PhoneNumberValidator::class],
            ['phone', 'unique'],
            ['display', 'string', 'length' => [3, 10]],

        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['password', 'passwordRepeat', 'phone', 'display', 'avatar'],
            'edit' => ['password', 'passwordRepeat', 'phone', 'display', 'avatar'],
            'profile' => ['password', 'passwordRepeat', 'phone', 'display', 'avatar'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => '电话号码',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
            'display' => '显示名',
            'avatar' => '头像',
        ];
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
