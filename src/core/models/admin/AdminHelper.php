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
                                'label' => '手工新建',
                                'url' => 'user/new'
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
                        'label' => '商品列表',
                        'url' => 'good/index'
                    ],
                    [
                        'label' => '新建商品',
                        'url' => 'good/new'
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
