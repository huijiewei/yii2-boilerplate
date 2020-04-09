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
    public $shopCategoryIds;

    public function rules()
    {
        return [
            [['name', 'alias', 'logo', 'description', 'shopCategoryIds'], 'trim'],
            [['name', 'alias'], 'required'],
            [['name', 'alias', 'logo', 'description'], 'string'],
            ['name', 'unique'],
            ['alias', 'unique'],
            [
                'shopCategoryIds',
                'exist',
                'targetClass' => ShopCategory::class,
                'targetAttribute' => 'id',
                'allowArray' => true
            ],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'alias',
            'logo',
            'description',
        ];
    }

    public function extraFields()
    {
        return [
            'shopCategories'
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '品牌名称',
            'alias' => '品牌别名',
            'logo' => '品牌 LOGO',
            'description' => '品牌介绍',
        ];
    }

    public function getShopCategories()
    {
        return $this->hasMany(ShopCategory::class, ['id' => 'shopCategoryId'])
            ->viaTable(ShopBrandCategory::tableName(), ['shopBrandId' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        ShopBrandCategory::deleteAll(['shopBrandId' => $this->id]);

        if (is_array($this->shopCategoryIds) && !empty($this->shopCategoryIds)) {
            $batchInsert = [];

            foreach ($this->shopCategoryIds as $shopCategoryId) {
                $batchInsert[] = [
                    $this->id,
                    $shopCategoryId,
                ];
            }

            if (!empty($batchInsert)) {
                ShopBrandCategory::getDb()
                    ->createCommand()
                    ->batchInsert(ShopBrandCategory::tableName(), ['shopBrandId', 'shopCategoryId'], $batchInsert)
                    ->execute();
            }
        }
    }
}
