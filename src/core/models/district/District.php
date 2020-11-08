<?php

namespace app\core\models\district;

use app\core\components\ActiveRecord;
use app\core\traits\TreeTrait;

/**
 * Class District
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 * @property string $code
 * @property string $zipCode
 * @property string $areaCode
 *
 * @package app\core\models\district
 */
class District extends ActiveRecord
{
    use TreeTrait;

    public function rules()
    {
        return [
            [['parentId', 'name', 'code', 'zipCode', 'areaCode'], 'trim'],
            [['parentId', 'name', 'code'], 'required'],
            ['code', 'unique']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'code',
            'image',
            'zipCode',
            'areaCode',
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
            'name' => '地区名称',
            'code' => '地区代码',
            'zipCode' => '邮政编码',
            'areaCode' => '电话区号',
        ];
    }
}
