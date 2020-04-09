<?php

namespace app\core\models\admin;

class AdminHelper
{
    public static function getFlattenPermissions()
    {
        $allPermissions = AdminHelper::getAllPermissions();

        $flattenPermissions = [];

        foreach ($allPermissions as $permission) {
            $flattenPermissions = array_merge($flattenPermissions, AdminHelper::getFlattenInPermissions($permission));
        }

        return $flattenPermissions;
    }

    public static function getAllPermissions()
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
                'name' => '用户管理',
                'children' => [
                    [
                        'name' => '用户列表',
                        'actionId' => 'user/index',
                    ],
                    [
                        'name' => '用户导出',
                        'actionId' => 'user/export',
                    ],
                    [
                        'name' => '用户新建',
                        'actionId' => 'user/create',
                    ],
                    [
                        'name' => '用户查看',
                        'actionId' => 'user/view',
                    ],
                    [
                        'name' => '用户编辑',
                        'actionId' => 'user/edit',
                        'combines' => ['user/view']
                    ],
                    [
                        'name' => '用户删除',
                        'actionId' => 'user/delete',
                    ],
                    [
                        'name' => '用户导入',
                        'actionId' => 'user/import',
                    ],
                ],
            ],
            [
                'name' => '商品管理',
                'children' => [
                    [
                        'children' => [
                            [
                                'name' => '商品列表',
                                'actionId' => 'shop-good/index'
                            ],
                            [
                                'name' => '商品导入',
                                'actionId' => 'shop-good/import',
                            ],
                            [
                                'name' => '商品新建',
                                'actionId' => 'shop-good/create'
                            ],
                            [
                                'name' => '商品查看',
                                'actionId' => 'shop-good/view'
                            ],
                            [
                                'name' => '商品编辑',
                                'actionId' => 'shop-good/edit',
                                'combines' => ['shop-good/view']
                            ],
                            [
                                'name' => '商品删除',
                                'actionId' => 'shop-good/delete'
                            ],
                        ]
                    ],
                    [
                        'children' => [
                            [
                                'name' => '商品分类',
                                'actionId' => 'shop-category/index'
                            ],
                            [
                                'name' => '商品分类新建',
                                'actionId' => 'shop-category/create'
                            ],
                            [
                                'name' => '商品分类查看',
                                'actionId' => 'shop-category/view'
                            ],
                            [
                                'name' => '商品分类编辑',
                                'actionId' => 'shop-category/edit',
                                'combines' => ['shop-category/view']
                            ],
                            [
                                'name' => '商品分类删除',
                                'actionId' => 'shop-category/delete'
                            ],
                        ]
                    ],
                    [
                        'children' => [
                            [
                                'name' => '商品品牌',
                                'actionId' => 'shop-brand/index'
                            ],
                            [
                                'name' => '商品品牌新建',
                                'actionId' => 'shop-brand/create'
                            ],
                            [
                                'name' => '商品品牌查看',
                                'actionId' => 'shop-brand/view'
                            ],
                            [
                                'name' => '商品品牌编辑',
                                'actionId' => 'shop-brand/edit',
                                'combines' => ['shop-brand/view']
                            ],
                            [
                                'name' => '商品品牌删除',
                                'actionId' => 'shop-brand/delete'
                            ],
                        ]
                    ],
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
                                'name' => '管理员查看',
                                'actionId' => 'admin/view',
                            ],
                            [
                                'name' => '管理员编辑',
                                'actionId' => 'admin/edit',
                                'combines' => ['admin/view']
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
                                'name' => '管理组查看',
                                'actionId' => 'admin-group/view',
                            ],
                            [
                                'name' => '管理组编辑',
                                'actionId' => 'admin-group/edit',
                                'combines' => ['admin-group/view']
                            ],
                            [
                                'name' => '管理组删除',
                                'actionId' => 'admin-group/delete',
                            ],
                        ],
                    ],
                    [
                        'children' => [
                            [
                                'name' => '操作日志查看',
                                'actionId' => 'admin-log/index',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private static function getFlattenInPermissions($permissions)
    {
        $flattenPermissions = [];

        if (isset($permissions['actionId'])) {
            $flattenPermissions[] = $permissions['actionId'];
        }

        if (isset($permissions['children'])) {
            foreach ($permissions['children'] as $child) {
                $flattenPermissions = array_merge($flattenPermissions, AdminHelper::getFlattenInPermissions($child));
            }
        }

        return $flattenPermissions;
    }

    public static function getAllMenus()
    {
        return [
            [
                'label' => '首页',
                'icon' => '<path d="M946.5 505L560.1 118.8l-25.9-25.9c-12.3-12.2-32.1-12.2-44.4 0L77.5 505c-12.3 12.3-18.9 28.6-18.8 46 0.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8 12.1-12.1 18.7-28.2 18.7-45.3 0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204z m217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z" p-id="7955"></path>',
                'url' => 'site/index',
                'open' => true,
            ],
            [
                'label' => '用户管理',
                'icon' => '<path d="M824.2 699.9c-25.4-25.4-54.7-45.7-86.4-60.4C783.1 602.8 812 546.8 812 484c0-110.8-92.4-201.7-203.2-200-109.1 1.7-197 90.6-197 200 0 62.8 29 118.8 74.2 155.5-31.7 14.7-60.9 34.9-86.4 60.4C345 754.6 314 826.8 312 903.8c-0.1 4.5 3.5 8.2 8 8.2h56c4.3 0 7.9-3.4 8-7.7 1.9-58 25.4-112.3 66.7-153.5C493.8 707.7 551.1 684 612 684c60.9 0 118.2 23.7 161.3 66.8C814.5 792 838 846.3 840 904.3c0.1 4.3 3.7 7.7 8 7.7h56c4.5 0 8.1-3.7 8-8.2-2-77-33-149.2-87.8-203.9zM612 612c-34.2 0-66.4-13.3-90.5-37.5-24.5-24.5-37.9-57.1-37.5-91.8 0.3-32.8 13.4-64.5 36.3-88 24-24.6 56.1-38.3 90.4-38.7 33.9-0.3 66.8 12.9 91 36.6 24.8 24.3 38.4 56.8 38.4 91.4 0 34.2-13.3 66.3-37.5 90.5-24.2 24.2-56.4 37.5-90.6 37.5z" p-id="8073"></path><path d="M361.5 510.4c-0.9-8.7-1.4-17.5-1.4-26.4 0-15.9 1.5-31.4 4.3-46.5 0.7-3.6-1.2-7.3-4.5-8.8-13.6-6.1-26.1-14.5-36.9-25.1-25.8-25.2-39.7-59.3-38.7-95.4 0.9-32.1 13.8-62.6 36.3-85.6 24.7-25.3 57.9-39.1 93.2-38.7 31.9 0.3 62.7 12.6 86 34.4 7.9 7.4 14.7 15.6 20.4 24.4 2 3.1 5.9 4.4 9.3 3.2 17.6-6.1 36.2-10.4 55.3-12.4 5.6-0.6 8.8-6.6 6.3-11.6-32.5-64.3-98.9-108.7-175.7-109.9-110.9-1.7-203.3 89.2-203.3 199.9 0 62.8 28.9 118.8 74.2 155.5-31.8 14.7-61.1 35-86.5 60.4-54.8 54.7-85.8 126.9-87.8 204-0.1 4.5 3.5 8.2 8 8.2h56.1c4.3 0 7.9-3.4 8-7.7 1.9-58 25.4-112.3 66.7-153.5 29.4-29.4 65.4-49.8 104.7-59.7 3.9-1 6.5-4.7 6-8.7z" p-id="8074"></path>',
                'children' => [
                    [
                        'label' => '用户列表',
                        'url' => 'user/index'
                    ],
                    [
                        'label' => '批量导入',
                        'url' => 'user/import'
                    ]
                ]
            ],
            [
                'label' => '商品管理',
                'icon' => '<path d="M832 312H696v-16c0-101.6-82.4-184-184-184s-184 82.4-184 184v16H192c-17.7 0-32 14.3-32 32v536c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V344c0-17.7-14.3-32-32-32z m-432-16c0-61.9 50.1-112 112-112s112 50.1 112 112v16H400v-16z m392 544H232V384h96v88c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-88h224v88c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-88h96v456z" p-id="8310"></path>',
                'children' => [
                    [
                        'label' => '商品列表',
                        'url' => 'shop-good/index'
                    ],
                    [
                        'label' => '商品分类',
                        'url' => 'shop-category/index'
                    ],
                    [
                        'label' => '商品品牌',
                        'url' => 'shop-brand/index'
                    ]
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => '<path d="M924.8 625.7l-65.5-56c3.1-19 4.7-38.4 4.7-57.8s-1.6-38.8-4.7-57.8l65.5-56c10.1-8.6 13.8-22.6 9.3-35.2l-0.9-2.6c-18.1-50.5-44.9-96.9-79.7-137.9l-1.8-2.1c-8.6-10.1-22.5-13.9-35.1-9.5l-81.3 28.9c-30-24.6-63.5-44-99.7-57.6l-15.7-85c-2.4-13.1-12.7-23.3-25.8-25.7l-2.7-0.5c-52.1-9.4-106.9-9.4-159 0l-2.7 0.5c-13.1 2.4-23.4 12.6-25.8 25.7l-15.8 85.4c-35.9 13.6-69.2 32.9-99 57.4l-81.9-29.1c-12.5-4.4-26.5-0.7-35.1 9.5l-1.8 2.1c-34.8 41.1-61.6 87.5-79.7 137.9l-0.9 2.6c-4.5 12.5-0.8 26.5 9.3 35.2l66.3 56.6c-3.1 18.8-4.6 38-4.6 57.1 0 19.2 1.5 38.4 4.6 57.1L99 625.5c-10.1 8.6-13.8 22.6-9.3 35.2l0.9 2.6c18.1 50.4 44.9 96.9 79.7 137.9l1.8 2.1c8.6 10.1 22.5 13.9 35.1 9.5l81.9-29.1c29.8 24.5 63.1 43.9 99 57.4l15.8 85.4c2.4 13.1 12.7 23.3 25.8 25.7l2.7 0.5c26.1 4.7 52.8 7.1 79.5 7.1 26.7 0 53.5-2.4 79.5-7.1l2.7-0.5c13.1-2.4 23.4-12.6 25.8-25.7l15.7-85c36.2-13.6 69.7-32.9 99.7-57.6l81.3 28.9c12.5 4.4 26.5 0.7 35.1-9.5l1.8-2.1c34.8-41.1 61.6-87.5 79.7-137.9l0.9-2.6c4.5-12.3 0.8-26.3-9.3-35zM788.3 465.9c2.5 15.1 3.8 30.6 3.8 46.1s-1.3 31-3.8 46.1l-6.6 40.1 74.7 63.9c-11.3 26.1-25.6 50.7-42.6 73.6L721 702.8l-31.4 25.8c-23.9 19.6-50.5 35-79.3 45.8l-38.1 14.3-17.9 97c-28.1 3.2-56.8 3.2-85 0l-17.9-97.2-37.8-14.5c-28.5-10.8-55-26.2-78.7-45.7l-31.4-25.9-93.4 33.2c-17-22.9-31.2-47.6-42.6-73.6l75.5-64.5-6.5-40c-2.4-14.9-3.7-30.3-3.7-45.5 0-15.3 1.2-30.6 3.7-45.5l6.5-40-75.5-64.5c11.3-26.1 25.6-50.7 42.6-73.6l93.4 33.2 31.4-25.9c23.7-19.5 50.2-34.9 78.7-45.7l37.9-14.3 17.9-97.2c28.1-3.2 56.8-3.2 85 0l17.9 97 38.1 14.3c28.7 10.8 55.4 26.2 79.3 45.8l31.4 25.8 92.8-32.9c17 22.9 31.2 47.6 42.6 73.6L781.8 426l6.5 39.9z" p-id="8428"></path><path d="M512 326c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176z m79.2 255.2C570 602.3 541.9 614 512 614c-29.9 0-58-11.7-79.2-32.8C411.7 560 400 531.9 400 502c0-29.9 11.7-58 32.8-79.2C454 401.6 482.1 390 512 390c29.9 0 58 11.6 79.2 32.8C612.3 444 624 472.1 624 502c0 29.9-11.7 58-32.8 79.2z" p-id="8429"></path>',
                'children' => [
                    [
                        'label' => '管理员',
                        'url' => 'admin/index'
                    ],
                    [
                        'label' => '管理组',
                        'url' => 'admin-group/index'
                    ],
                    [
                        'label' => '操作日志',
                        'url' => 'admin-log/index'
                    ],
                ],
            ],
        ];
    }
}
