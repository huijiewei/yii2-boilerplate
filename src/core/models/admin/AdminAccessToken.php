<?php

namespace app\core\models\admin;

use app\core\components\ActiveRecord;

/**
 * Class AdminAccessToken
 *
 * @property integer $id
 * @property string $clientId
 * @property integer $adminId
 * @property string $accessToken
 * @property string $remoteAddr
 * @property string $userAgent
 * @property string $updatedAt
 *
 * @package app\core\models\admin
 */
class AdminAccessToken extends ActiveRecord
{
    public static function deleteAccessToken($adminId, $clientId)
    {
        static::deleteAll(['adminId' => $adminId, 'clientId' => $clientId]);
    }

    public static function generateAccessToken($adminId, $clientId, $remoteAddr, $userAgent)
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

        $adminAccessToken->accessToken = $accessToken;
        $adminAccessToken->remoteAddr = $remoteAddr;
        $adminAccessToken->userAgent = $userAgent;

        $adminAccessToken->save(false);

        return $adminAccessToken;
    }
}
