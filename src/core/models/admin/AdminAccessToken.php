<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 12:47
 */

namespace app\core\models\admin;

use app\core\components\ActiveRecord;

/**
 * Class AdminAccessToken
 *
 * @property integer $id
 * @property integer $adminId
 * @property string $clientId
 * @property string $token
 * @property string $updatedAt
 *
 * @package app\core\models\admin
 */
class AdminAccessToken extends ActiveRecord
{
    public static function generateAccessToken($adminId, $clientId)
    {
        /* @var $adminAccessToken AdminAccessToken|null */
        $adminAccessToken = AdminAccessToken::find()
            ->where(['clientId' => $clientId, 'adminId' => $adminId])
            ->one();

        if ($adminAccessToken == null) {
            $adminAccessToken = new AdminAccessToken();

            $adminAccessToken->adminId = $adminId;
            $adminAccessToken->clientId = $clientId;
        }

        $randomString = \Yii::$app->getSecurity()->generateRandomString() . '_' . $adminId . '_' . $clientId;

        $accessToken = \Yii::$app->getSecurity()->generatePasswordHash($randomString);

        $adminAccessToken->token = $accessToken;

        $adminAccessToken->save(false);

        return $adminAccessToken;
    }
}
