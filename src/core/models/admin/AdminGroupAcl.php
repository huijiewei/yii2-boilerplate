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
    const CACHE_PREFIX = 'BP_ADMIN_GROUP_ACL_';

    /**
     * @param $groupId
     *
     * @return array
     */
    public static function getAclByGroupId($groupId)
    {
        $cacheKey = static::CACHE_PREFIX . $groupId;

        $acl = \Yii::$app->getCache()->get($cacheKey);

        if ($acl === false) {
            $acl = static::find()
                ->where(['groupId' => $groupId])
                ->select('actionId')
                ->column();

            \Yii::$app->getCache()->set($cacheKey, $acl);
        }

        return $acl;
    }

    public static function getAcl()
    {
        return [
            [
                'name' => '管理首页',
                'items' => [
                ],
            ],
            [
                'name' => '系统管理',
                'items' => [
                    [
                        'items' => [
                            [
                                'name' => '管理员列表',
                                'route' => 'setting/admins:GET',
                            ],
                            [
                                'name' => '管理员新建',
                                'route' => 'setting/admins:POST',
                            ],
                            [
                                'name' => '管理员信息',
                                'route' => 'setting/admin:GET',
                            ],
                            [
                                'name' => '管理员编辑',
                                'route' => 'setting/admin:PUT',
                            ],
                            [
                                'name' => '管理员删除',
                                'route' => 'setting/admin:DELETE',
                            ],
                        ],
                    ],
                    [
                        'items' => [
                            [
                                'name' => '管理组列表',
                                'route' => 'setting/group',
                            ],
                            [
                                'name' => '管理组新建',
                                'route' => 'setting/group/create',
                            ],
                            [
                                'name' => '管理组编辑',
                                'route' => 'setting/group/edit',
                            ],
                            [
                                'name' => '管理组删除',
                                'route' => 'setting/group/create',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
