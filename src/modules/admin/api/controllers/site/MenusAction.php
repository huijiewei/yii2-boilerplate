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
                        'url' => 'user/new'
                    ]
                ]
            ],
            [
                'label' => '商品管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
            [
                'label' => '订单管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
            [
                'label' => '运营管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
            [
                'label' => '报表管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
            [
                'label' => '财务管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => 'car',
                'url' => 'car',
                'children' => [
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ],
                    [
                        'label' => '车辆列表',
                        'url' => 'car'
                    ]
                ],
            ],
        ];
    }
}
