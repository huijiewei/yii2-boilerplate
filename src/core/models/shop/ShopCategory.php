<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/8/1
 * Time: 10:26
 */

namespace app\core\models\shop;

use app\core\components\ActiveRecord;
use huijiewei\closuretable\ClosureTableTrait;

/**
 * Class ShopCategory
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 *
 * @package app\core\models\shop
 */
class ShopCategory extends ActiveRecord
{
    use ClosureTableTrait;

    public function rules()
    {
        return [
            [['parentId', 'name'], 'trim'],
            [['parentId', 'name'], 'required'],
        ];
    }

    public function extraFields()
    {
        return [
            'ancestor',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'icon',
            'parentId',
        ];
    }

    public function attributeLabels()
    {
        return [
            'parentId' => '上级分类',
            'name' => '分类名称',
        ];
    }
}
