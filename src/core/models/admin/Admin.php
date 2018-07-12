<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 00:06
 */

namespace app\core\models\admin;

use app\core\models\Identity;

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

    public function can($actionId)
    {
        return in_array($actionId, AdminGroupAcl::getAclByGroupId($this->groupId));
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AdminGroup::class, ['id' => 'groupId']);
    }
}
