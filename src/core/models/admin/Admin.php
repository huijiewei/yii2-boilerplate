<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 00:06
 */

namespace app\core\models\admin;

use app\core\models\Identity;
use app\core\validators\PhoneNumberValidator;

/**
 * Class Admin
 *
 * @property integer $id
 * @property integer $groupId
 * @property string $phone
 * @property string $displayName
 * @property string $displayIcon
 *
 * @property AdminGroup $group
 *
 * @package app\core\models\admin
 */
class Admin extends Identity
{
    public $passwordRepeat;

    /**
     * @param mixed $token
     * @param string $clientId
     *
     * @return Admin|null
     */
    public static function findByAccessToken($token, $clientId = '')
    {
        return static::findOne([
            'id' => AdminAccessToken::find()
                ->where(['clientId' => $clientId, 'token' => $token])
                ->select('adminId')
        ]);
    }

    public function rules()
    {
        return [
            [['groupId', 'phone', 'displayName', 'displayIcon', 'password', 'passwordRepeat'], 'trim'],
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
            ['groupId', 'required', 'on' => ['create', 'edit']],
            [
                'groupId',
                'exist',
                'targetClass' => AdminGroup::class,
                'targetAttribute' => 'id',
                'on' => ['create', 'edit'],
            ],
            ['phone', 'required'],
            ['phone', PhoneNumberValidator::class],
            ['phone', 'unique'],
            ['displayName', 'string', 'length' => [3, 10]],

        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['groupId', 'password', 'passwordRepeat', 'phone', 'displayName', 'displayIcon'],
            'edit' => ['groupId', 'password', 'passwordRepeat', 'phone', 'displayName', 'displayIcon'],
            'profile' => ['groupId', 'password', 'passwordRepeat', 'phone', 'displayName', 'displayIcon'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'groupId' => '所属管理组',
            'phone' => '电话号码',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
            'displayName' => '显示名',
            'displayIcon' => '头像',
        ];
    }

    public function can($actionId)
    {
        return in_array($actionId, $this->getGroupAcl());
    }

    public function getGroupAcl()
    {
        return AdminGroup::getAclByGroupId($this->groupId);
    }

    public function getGroupMenus()
    {
        return AdminGroup::getMenuByGroupId($this->groupId);
    }

    public function extraFields()
    {
        return [
            'group',
        ];
    }

    /**
     * @param string $clientId
     *
     * @return AdminAccessToken
     */
    public function generateAccessToken($clientId = '')
    {
        return AdminAccessToken::generateAccessToken($this->id, $clientId);
    }

    public function deleteAccessToken($clientId = '')
    {
        AdminAccessToken::deleteAccessToken($this->id, $clientId);
    }

    public function fields()
    {
        return [
            'id',
            'phone',
            'displayName',
            'displayIcon',
            'groupId',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AdminGroup::class, ['id' => 'groupId']);
    }
}
