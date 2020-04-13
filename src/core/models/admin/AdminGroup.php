<?php

namespace app\core\models\admin;

use app\core\components\ActiveRecord;
use app\core\helpers\StringHelper;

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
    public const PERMISSIONS_CACHE_PREFIX = 'BP_ADMIN_GROUP_PERMISSIONS_';

    public $permissions;

    public static function checkUrlInPermissions($url, $permissions)
    {
        $urlSplit = explode('/', $url);

        foreach ($permissions as $permission) {
            $permissionSplit = explode('/', $permission);

            if (count($urlSplit) != count($permissionSplit)) {
                continue;
            }

            $match = false;

            foreach ($permissionSplit as $idx => $ps) {
                if (StringHelper::startsWith($ps, ':')) {
                    $match = true;
                } else {
                    $match = $ps == $urlSplit[$idx];
                }
            }

            if ($match) {
                return true;
            }
        }

        return false;
    }

    public static function getMenuById($id)
    {

        function getMenu($menu, $permissions)
        {
            if (
                isset($menu['url']) &&
                !AdminGroup::checkUrlInPermissions($menu['url'], $permissions) &&
                (!isset($menu['open']) || !$menu['open'])
            ) {
                return false;
            }

            $children = false;

            if (isset($menu['children'])) {
                $children = [];

                foreach ($menu['children'] as $child) {
                    $item = getMenu($child, $permissions);

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
        $groupPermissions = AdminGroup::getPermissionsById($id);

        $menus = [];

        foreach ($allMenus as $menu) {
            $item = getMenu($menu, $groupPermissions);

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
    public static function getPermissionsById($groupId)
    {
        $cacheKey = static::PERMISSIONS_CACHE_PREFIX . $groupId;

        $acl = \Yii::$app->getCache()->get($cacheKey);

        if ($acl !== false) {
            return $acl;
        }

        $acl = AdminGroupPermission::find()
            ->where(['adminGroupId' => $groupId])
            ->select('actionId')
            ->column();

        \Yii::$app->getCache()->set($cacheKey, $acl);

        return $acl;
    }

    public static function clearPermissionsCache($groupId)
    {
        \Yii::$app->getCache()->delete(static::PERMISSIONS_CACHE_PREFIX . $groupId);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        AdminGroupPermission::deleteAll(['adminGroupId' => $this->id]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->permissions)) {
            AdminGroupPermission::updatePermissions(
                $this->id,
                $this->permissions,
                $insert ? [] : AdminGroup::getPermissionsById($this->id)
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
        if (Admin::find()->where(['adminGroupId' => $this->id])->exists()) {
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
            'permissions' => function () {
                return AdminGroup::getPermissionsById($this->id);
            },
        ];
    }

    public function rules()
    {
        return [
            [['name', 'permissions'], 'trim'],
            ['name', 'required'],
            ['name', 'string', 'length' => [3, 10]],
            ['name', 'unique']
        ];
    }
}
