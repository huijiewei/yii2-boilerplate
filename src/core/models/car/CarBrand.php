<?php

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
