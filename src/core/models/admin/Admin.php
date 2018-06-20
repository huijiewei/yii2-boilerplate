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


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }


    public function getAuthKey()
    {
        return 'BP';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}
