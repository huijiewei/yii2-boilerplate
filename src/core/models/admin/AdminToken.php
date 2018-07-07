<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 12:47
 */

namespace app\core\models\admin;

use yii\db\ActiveRecord;

/**
 * Class AdminToken
 *
 * @property integer $id
 * @property integer $adminId
 * @property string $accessType
 * @property string $accessToken
 * @property string $updatedAt
 *
 * @package app\core\models\admin
 */
class AdminToken extends ActiveRecord
{
}
