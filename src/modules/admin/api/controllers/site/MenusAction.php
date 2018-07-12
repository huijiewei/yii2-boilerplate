<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/28
 * Time: 01:50
 */

namespace app\modules\admin\api\controllers\site;

use app\modules\admin\api\ControllerAction;

class MenusAction extends ControllerAction
{
    public function run()
    {
        return [
            [
                'label' => '首页',
                'icon' => 'home',
                'url' => '',
            ],
            [
                'label' => '会员管理',
                'icon' => 'user',
                'url' => 'user',
                'children' => [
                    [
                        'label' => '会员列表',
                        'url' => 'user'
                    ],
                    [
                        'label' => '新建会员',
                        'url' => 'user/new',
                        'children' => [
                            [
                                'label' => '手工新建',
                                'url' => 'user/new'
                            ],
                            [
                                'label' => '批量导入',
                                'url' => 'user/new/import'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'label' => '商品管理',
                'icon' => 'gift',
                'url' => 'good',
                'children' => [
                    [
                        'label' => '商品列表',
                        'url' => 'good'
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
                'url' => 'order',
                'children' => [
                    [
                        'label' => '订单列表',
                        'url' => 'order'
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
                'url' => 'business',
                'children' => [
                    [
                        'label' => '运营管理',
                        'url' => 'business'
                    ],
                ],
            ],
            [
                'label' => '报表管理',
                'icon' => 'line-chart',
                'url' => 'report',
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
                        'url' => 'finance'
                    ],
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => 'setting',
                'children' => [
                    [
                        'label' => '系统设置',
                        'url' => 'setting'
                    ],
                    [
                        'label' => '管理员',
                        'url' => 'admin'
                    ],
                    [
                        'label' => '管理组',
                        'url' => 'admin-group'
                    ],
                ],
            ],
        ];
    }
}
