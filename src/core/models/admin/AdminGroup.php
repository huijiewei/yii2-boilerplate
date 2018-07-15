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
 * @package app\core\models\admin
 */
class AdminGroup extends ActiveRecord
{
    public $acl;

    public function rules()
    {
        return [
            [['name', 'acl'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'length' => [3, 10]],
        ];
    }

    public function extraFields()
    {
        return [
            'acl' => function () {
                return AdminGroupAcl::getAclByGroupId($this->id);
            },
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '名称',
        ];
    }

    public function beforeDelete()
    {
        if (Admin::find()->where(['groupId' => $this->id])->exists()) {
            $this->addError('id', '管理组内还有管理员，无法删除');

            return false;
        }

        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        parent::afterDelete();

        AdminGroupAcl::deleteAll(['groupId' => $this->id]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->acl)) {
            AdminGroupAcl::updateAcl(
                $this->id,
                $this->acl,
                $insert ? [] : AdminGroupAcl::getAclByGroupId($this->id)
            );
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
