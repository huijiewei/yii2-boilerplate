<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 12:26
 */

namespace app\core\models\admin;

use app\core\components\ActiveRecord;

/**
 * Class AdminGroup
 *
 * @property integer $id
 * @property string $name
 *
 * @property AdminGroupAcl[] $acl
 *
 * @package app\core\models\admin
 */
class AdminGroup extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'length' => [3, 10]],
        ];
    }

    public function extraFields()
    {
        return [
            'acl'
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '名称',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcl()
    {
        return $this->hasMany(AdminGroupAcl::class, ['groupId' => 'id']);
    }

    public function beforeDelete()
    {
        if (Admin::find()->where(['groupId' => $this->id])->exists()) {
            return false;
        }

        return parent::beforeDelete();
    }
}
