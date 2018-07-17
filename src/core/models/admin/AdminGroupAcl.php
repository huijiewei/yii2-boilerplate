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

    public function fields()
    {
        return [
            'actionId',
        ];
    }

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

    public static function getAllAcl()
    {
        return [
            [
                'name' => '管理首页',
                'children' => [
                    [
                        'name' => '测试短信发送',
                        'actionId' => 'site/sms-send'
                    ],
                    [
                        'name' => '更新系统缓存',
                        'actionId' => 'site/clean-cache'
                    ]
                ],
            ],
            [
                'name' => '系统管理',
                'children' => [
                    [
                        'children' => [
                            [
                                'name' => '管理员列表',
                                'actionId' => 'admin/index',
                            ],
                            [
                                'name' => '管理员新建',
                                'actionId' => 'admin/create',
                            ],
                            [
                                'name' => '管理员编辑',
                                'actionId' => 'admin/edit',
                            ],
                            [
                                'name' => '管理员删除',
                                'actionId' => 'admin/delete',
                            ],
                        ],
                    ],
                    [
                        'children' => [
                            [
                                'name' => '管理组列表',
                                'actionId' => 'admin-group/index',
                            ],
                            [
                                'name' => '管理组新建',
                                'actionId' => 'admin-group/create',
                            ],
                            [
                                'name' => '管理组编辑',
                                'actionId' => 'admin-group/edit',
                            ],
                            [
                                'name' => '管理组删除',
                                'actionId' => 'admin-group/delete',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

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
                static::getDb()
                    ->createCommand()
                    ->batchInsert(static::tableName(), ['groupId', 'actionId'], $ins)
                    ->execute();
            }
        }

        if (!empty($deleteAcl)) {
            static::deleteAll(['groupId' => $groupId, 'actionId' => $deleteAcl]);
        }

        \Yii::$app->getCache()->delete(static::CACHE_PREFIX . $groupId);
    }
}
