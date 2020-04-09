<?php

namespace app\core\models\admin;

use app\core\models\Identity;
use app\core\validators\PhoneNumberValidator;

/**
 * Class Admin
 *
 * @property integer $adminGroupId
 * @property string $phone
 * @property string $email
 * @property string $name
 * @property string $avatar
 *
 * @property AdminGroup $adminGroup
 *
 * @package app\core\models\admin
 */
class Admin extends Identity
{
    public $authKey;

    /**
     * @param string $accessToken
     * @param string $clientId
     *
     * @return Admin|null|array
     */
    public static function findByAccessToken($accessToken, $clientId = '')
    {
        return static::find()
            ->with(['adminGroup'])
            ->where([
                'id' => AdminAccessToken::find()
                    ->where(['clientId' => $clientId, 'accessToken' => $accessToken])
                    ->select('adminId')
            ])
            ->one();
    }

    public function rules()
    {
        return [
            [['adminGroupId', 'phone', 'email', 'name', 'avatar', 'password', 'passwordRepeat'], 'trim'],
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
            ['adminGroupId', 'required', 'on' => ['create', 'edit']],
            [
                'adminGroupId',
                'exist',
                'targetClass' => AdminGroup::class,
                'targetAttribute' => 'id',
                'on' => ['create', 'edit'],
            ],
            [['phone', 'email'], 'required'],
            ['phone', PhoneNumberValidator::class],
            ['phone', 'unique'],
            ['email', 'email'],
            ['email', 'unique'],
            ['name', 'string', 'length' => [2, 6]],

        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['adminGroupId', 'password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
            'edit' => ['adminGroupId', 'password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
            'profile' => ['password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'adminGroupId' => '所属管理组',
            'phone' => '电话',
            'email' => '邮箱',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
            'name' => '名称',
            'avatar' => '头像',
        ];
    }

    public function can($actionId)
    {
        return in_array($actionId, $this->getGroupPermissions());
    }

    public function getGroupPermissions()
    {
        return AdminGroup::getPermissionsById($this->adminGroupId);
    }

    public function getGroupMenus()
    {
        return AdminGroup::getMenuById($this->adminGroupId);
    }

    public function extraFields()
    {
        return [
            'adminGroup',
        ];
    }

    /**
     * @param string $clientId
     * @param string $remoteAddr
     * @param string $userAgent
     *
     * @return AdminAccessToken
     */
    public function generateAccessToken($clientId = '', $remoteAddr = '', $userAgent = '')
    {
        return AdminAccessToken::generateAccessToken($this->id, $clientId, $remoteAddr, $userAgent);
    }

    public function logout($clientId, $remoteAddr, $userAgent)
    {
        $adminLog = $this->createLog();
        $adminLog->type = AdminLog::TYPE_LOGIN;
        $adminLog->remoteAddr = $remoteAddr;
        $adminLog->userAgent = $userAgent;
        $adminLog->method = 'POST';
        $adminLog->action = 'Logout';
        $adminLog->status = AdminLog::STATUS_SUCCESS;
        $adminLog->save(false);

        AdminAccessToken::deleteAccessToken($this->id, $clientId);
    }

    public function createLog()
    {
        $adminLog = new AdminLog();
        $adminLog->adminId = $this->id;

        return $adminLog;
    }

    public function fields()
    {
        return [
            'id',
            'phone',
            'email',
            'name',
            'avatar',
            'createdAt',
            'adminGroupId',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminGroup()
    {
        return $this->hasOne(AdminGroup::class, ['id' => 'adminGroupId']);
    }
}
