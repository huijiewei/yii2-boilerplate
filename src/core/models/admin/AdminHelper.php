<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/17
 * Time: 10:46
 */

namespace app\core\models\admin;

class AdminHelper
{
    public static function getFlattenAcl()
    {
        $allAcl = AdminHelper::getAllAcl();

        $flattenAcl = [];

        foreach ($allAcl as $acl) {
            $flattenAcl = array_merge($flattenAcl, AdminHelper::getFlattenInAcl($acl));
        }

        return $flattenAcl;
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
                'name' => '会员管理',
                'children' => [
                    [
                        'name' => '会员列表',
                        'actionId' => 'user/index',
                    ],
                    [
                        'name' => '会员导出',
                        'actionId' => 'user/export',
                    ],
                    [
                        'name' => '会员新建',
                        'actionId' => 'user/create',
                    ],
                    [
                        'name' => '会员编辑',
                        'actionId' => 'user/edit',
                    ],
                    [
                        'name' => '会员导入',
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
                                'actionId' => 'good/index'
                            ],
                            [
                                'name' => '新建商品',
                                'actionId' => 'good/new'
                            ],
                            [
                                'name' => '编辑商品',
                                'actionId' => 'good/edit'
                            ],
                            [
                                'name' => '删除商品',
                                'actionId' => 'good/delete'
                            ],
                        ]
                    ],
                    [
                        'name' => '商品分类',
                        'actionId' => 'good/category'
                    ],
                    [
                        'name' => '商品属性',
                        'actionId' => 'good/property'
                    ],
                    [
                        'name' => '商品特点',
                        'actionId' => 'good/feature'
                    ],
                    [
                        'name' => '商品品牌',
                        'actionId' => 'good/brand'
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

    private static function getFlattenInAcl($acl)
    {
        $flattenAcl = [];

        if (isset($acl['actionId'])) {
            $flattenAcl[] = $acl['actionId'];
        }

        if (isset($acl['children'])) {
            foreach ($acl['children'] as $child) {
                $flattenAcl = array_merge($flattenAcl, AdminHelper::getFlattenInAcl($child));
            }
        }

        return $flattenAcl;
    }

    public static function getAllMenus()
    {
        return [
            [
                'label' => '首页',
                'icon' => 'home',
                'url' => 'site/index',
                'public' => true,
            ],
            [
                'label' => '会员管理',
                'icon' => 'user',
                'children' => [
                    [
                        'label' => '会员列表',
                        'url' => 'user/index'
                    ],
                    [
                        'label' => '新建会员',
                        'children' => [
                            [
                                'label' => '新建会员',
                                'url' => 'user/create'
                            ],
                            [
                                'label' => '批量导入',
                                'url' => 'user/import'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'label' => '商品管理',
                'icon' => 'gift',
                'children' => [
                    [
                        'label' => '新建商品',
                        'url' => 'good/new'
                    ],
                    [
                        'label' => '商品列表',
                        'url' => 'good/index'
                    ],
                    [
                        'label' => '商品分类',
                        'url' => 'good/category'
                    ],
                    [
                        'label' => '商品属性',
                        'url' => 'good/property'
                    ],
                    [
                        'label' => '商品特点',
                        'url' => 'good/feature'
                    ],
                    [
                        'label' => '商品品牌',
                        'url' => 'good/brand'
                    ]
                ],
            ],
            [
                'label' => '订单管理',
                'icon' => 'book',
                'children' => [
                    [
                        'label' => '订单列表',
                        'url' => 'order/index'
                    ],
                    [
                        'label' => '运费设置',
                        'url' => 'order/freight'
                    ],
                    [
                        'label' => '快递查询',
                        'url' => 'order/express'
                    ],
                ],
            ],
            [
                'label' => '运营管理',
                'icon' => 'coffee',
                'children' => [
                    [
                        'label' => '运营管理',
                        'url' => 'business/index'
                    ],
                ],
            ],
            [
                'label' => '报表管理',
                'icon' => 'line-chart',
                'children' => [
                    [
                        'label' => '商品报表',
                        'url' => 'report/good'
                    ],
                    [
                        'label' => '订单报表',
                        'url' => 'report/order'
                    ],
                ],
            ],
            [
                'label' => '财务管理',
                'icon' => 'pay-circle-o',
                'children' => [
                    [
                        'label' => '财务管理',
                        'url' => 'finance/index'
                    ],
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => 'setting',
                'children' => [
                    [
                        'label' => '系统设置',
                        'url' => 'setting/index'
                    ],
                    [
                        'label' => '管理员',
                        'url' => 'admin/index'
                    ],
                    [
                        'label' => '管理组',
                        'url' => 'admin-group/index'
                    ],
                ],
            ],
        ];
    }
}
