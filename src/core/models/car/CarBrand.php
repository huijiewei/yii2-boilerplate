<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/8/1
 * Time: 16:22
 */

namespace app\core\models\car;

use app\core\components\ActiveRecord;
use huijiewei\closuretable\ClosureTableTrait;

/**
 * Class CarBrand
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 *
 * @package app\core\models\car
 */
class CarBrand extends ActiveRecord
{
    use ClosureTableTrait;
}
