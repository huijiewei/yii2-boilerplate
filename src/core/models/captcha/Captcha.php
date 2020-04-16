<?php

namespace app\core\models\captcha;

use app\core\components\ActiveRecord;

/**
 * Class Captcha
 *
 * @property integer $id
 * @property string $code
 * @property string $uuid
 * @property string $userAgent
 * @property string $remoteAddr
 * @property string $createdAt
 *
 * @package app\core\models\captcha
 */
class Captcha extends ActiveRecord
{

}
