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
    const ACL_CACHE_PREFIX = 'BP_ADMIN_GROUP_ACL_';

    public $acl;

    public static function getMenuByGroupId($groupId)
    {
        function getMenu($menu, $acl)
        {
            if (isset($menu['url'])
                && !in_array($menu['url'], $acl)
                && (!isset($menu['public']) || !$menu['public'])) {
                return false;
            }

            $children = false;

            if (isset($menu['children'])) {
                $children = [];

                foreach ($menu['children'] as $child) {
                    $item = getMenu($child, $acl);

                    if ($item !== false) {
                        $children[] = $item;
                    }
                }

                if (empty($children)) {
                    return false;
                }
            }

            $result = [];

            foreach ($menu as $key => $value) {
                if ($key != 'children') {
                    $result[$key] = $value;
                }
            }

            if ($children !== false) {
                $result['children'] = $children;
            }

            return $result;
        }

        $allMenus = AdminHelper::getAllMenus();
        $groupAcl = AdminGroup::getAclByGroupId($groupId);

        $menus = [];

        foreach ($allMenus as $menu) {
            $item = getMenu($menu, $groupAcl);

            if ($item !== false) {
                $menus[] = $item;
            }
        }

        return $menus;
    }

    /**
     * @param $groupId
     *
     * @return array
     */
    public static function getAclByGroupId($groupId)
    {
        $cacheKey = static::ACL_CACHE_PREFIX . $groupId;

        $acl = \Yii::$app->getCache()->get($cacheKey);

        if ($acl !== false) {
            return $acl;
        }

        $acl = AdminGroupAcl::find()
            ->where(['groupId' => $groupId])
            ->select('actionId')
            ->column();

        \Yii::$app->getCache()->set($cacheKey, $acl);

        return $acl;
    }

    public static function clearAclCache($groupId)
    {
        \Yii::$app->getCache()->delete(static::ACL_CACHE_PREFIX . $groupId);
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
                $insert ? [] : AdminGroup::getAclByGroupId($this->id)
            );
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function attributeLabels()
    {
        return [
            'name' => '管理组名称',
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

    public function fields()
    {
        return [
            'id',
            'name'
        ];
    }

    public function extraFields()
    {
        return [
            'acl' => function () {
                return AdminGroup::getAclByGroupId($this->id);
            },
        ];
    }

    public function rules()
    {
        return [
            [['name', 'acl'], 'trim'],
            ['name', 'required'],
            ['name', 'string', 'length' => [3, 10]],
            ['name', 'unique']
        ];
    }
}
