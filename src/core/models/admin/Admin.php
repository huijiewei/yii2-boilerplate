<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 00:06
 */

namespace app\core\models\admin;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class Admin
 *
 * @property integer $id
 * @property integer $groupId
 * @property string $phone
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $displayName
 * @property string $displayIcon
 * @property string $createdAt
 *
 * @property AdminGroup $group
 *
 * @package app\core\models\admin
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    /**
     * @param int $id
     *
     * @return Admin|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @param mixed $token
     * @param null $type
     *
     * @return Admin|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'id' => AdminToken::find()
                ->where(['accessType' => $type ?? '', 'accessToken' => $token])
                ->select('adminId')
        ]);
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AdminGroup::class, ['id' => 'groupId']);
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey = $authKey;
    }

    /**
     *  不允许删除
     *
     * @return bool
     */
    public function beforeDelete()
    {
        return false;
    }
}
