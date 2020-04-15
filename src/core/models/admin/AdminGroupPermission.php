<?php

namespace app\core\models\admin;

use app\core\components\ActiveRecord;

/**
 * Class AdminGroupPermission
 *
 * @property integer $id
 * @property integer $adminGroupId
 * @property string $actionId
 *
 * @package app\core\models\admin
 */
class AdminGroupPermission extends ActiveRecord
{
    public static function updatePermissions($adminGroupId, $newPermissions, $oldPermissions)
    {
        $insertPermissions = array_values(array_diff($newPermissions, $oldPermissions));
        $deletePermissions = array_values(array_diff($oldPermissions, $newPermissions));

        if (count($insertPermissions) > 0) {
            $ins = [];

            foreach ($insertPermissions as $permission) {
                if (empty($permission) || $permission == '0') {
                    continue;
                }

                $ins[] = [$adminGroupId, $permission];
            }

            if (!empty($ins)) {
                AdminGroupPermission::getDb()
                    ->createCommand()
                    ->batchInsert(AdminGroupPermission::tableName(), ['adminGroupId', 'actionId'], $ins)
                    ->execute();
            }
        }

        if (!empty($deletePermissions)) {
            AdminGroupPermission::deleteAll(['adminGroupId' => $adminGroupId, 'actionId' => $deletePermissions]);
        }

        AdminGroup::clearPermissionsCache($adminGroupId);
    }

    public function fields()
    {
        return [
            'actionId',
        ];
    }
}
