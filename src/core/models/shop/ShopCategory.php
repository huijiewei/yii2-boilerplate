<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/8/1
 * Time: 10:26
 */

namespace app\core\models\shop;

use app\core\components\ActiveRecord;
use huijiewei\tree\TreeTrait;

/**
 * Class ShopCategory
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 * @property string $icon
 * @property string $image
 *
 * @package app\core\models\shop
 */
class ShopCategory extends ActiveRecord
{
    use TreeTrait;

    public function rules()
    {
        return [
            [['parentId', 'name', 'icon', 'image'], 'trim'],
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
            'parentId',
        ];
    }

    public function attributeLabels()
    {
        return [
            'parentId' => '上级分类',
            'name' => '分类名称',
            'icon' => '分类图标',
            'image' => '分类图片',
        ];
    }
}
