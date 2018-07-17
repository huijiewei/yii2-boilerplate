<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/22
 * Time: 09:53
 */

namespace app\core\models\admin;

use app\core\components\ActiveRecord;

/**
 * Class AdminGroupAcl
 *
 * @property integer $id
 * @property integer $groupId
 * @property string $actionId
 *
 * @package app\core\models\admin
 */
class AdminGroupAcl extends ActiveRecord
{
    public static function updateAcl($groupId, $newAcl, $oldAcl)
    {
        $insertAcl = array_values(array_diff($newAcl, $oldAcl));
        $deleteAcl = array_values(array_diff($oldAcl, $newAcl));

        if (count($insertAcl) > 0) {
            $ins = [];

            foreach ($insertAcl as $acl) {
                if (empty($acl) || $acl == '0') {
                    continue;
                }

                $ins[] = [$groupId, $acl];
            }

            if (!empty($ins)) {
                AdminGroupAcl::getDb()
                    ->createCommand()
                    ->batchInsert(AdminGroupAcl::tableName(), ['groupId', 'actionId'], $ins)
                    ->execute();
            }
        }

        if (!empty($deleteAcl)) {
            AdminGroupAcl::deleteAll(['groupId' => $groupId, 'actionId' => $deleteAcl]);
        }

        AdminGroup::clearAclCache($groupId);
    }

    public function fields()
    {
        return [
            'actionId',
        ];
    }
}
