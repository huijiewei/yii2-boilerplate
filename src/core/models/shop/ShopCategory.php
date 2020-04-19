<?php

namespace app\core\models\shop;

use app\core\components\ActiveRecord;
use app\core\traits\TreeTrait;

/**
 * Class ShopCategory
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 * @property string $icon
 * @property string $image
 * @property string $description
 *
 * @package app\core\models\shop
 */
class ShopCategory extends ActiveRecord
{
    use TreeTrait;

    public function rules()
    {
        return [
            [['parentId', 'name', 'icon', 'image', 'description'], 'trim'],
            [['parentId', 'name'], 'required'],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'icon',
            'image',
            'description',
            'parentId',
        ];
    }

    public function extraFields()
    {
        return [
            'parents',
            'children',
        ];
    }

    public function attributeLabels()
    {
        return [
            'parentId' => '上级分类',
            'name' => '分类名称',
            'icon' => '分类图标',
            'image' => '分类图片',
            'description' => '分类介绍',
        ];
    }

    public function delete()
    {
        $childrenIds = $this->getChildrenIds(true);

        if (ShopProduct::find()->where(['shopCategoryId' => $childrenIds])->exists()) {
            return false;
        }

        ShopCategory::deleteAll(['id' => $childrenIds]);
        ShopBrandCategory::deleteAll(['shopCategoryId' => $childrenIds]);

        static::clearCache();

        return true;
    }
}
