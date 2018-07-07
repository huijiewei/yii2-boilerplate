<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 15:36
 */

namespace app\core\components;

use app\core\traits\SoftDeleteTrait;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use SoftDeleteTrait;
}
