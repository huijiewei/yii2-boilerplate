<?php

namespace app\core\models\shop;

use app\core\components\ActiveRecord;

/**
 * Class ShopBrand
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $logo
 * @property string $description
 *
 * @property ShopBrandCategory[] $shopBrandCategories
 *
 * @package app\core\models\shop
 */
class ShopBrand extends ActiveRecord
{
    public function getShopCategories()
    {
        return $this->hasMany(ShopCategory::class, ['id' => 'shopCategoryId'])
            ->viaTable(ShopBrandCategory::tableName(), ['shopBrandId' => 'id']);
    }
}
