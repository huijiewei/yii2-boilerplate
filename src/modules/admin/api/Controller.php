<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:29
 */

namespace app\modules\admin\api;

use app\core\components\RestController;
use app\core\models\admin\Admin;
use yii\helpers\ArrayHelper;

/**
 * Class Controller
 *
 * @method Admin getIdentity()
 *
 * @package app\modules\admin\api
 */
class Controller extends RestController
{
    public function behaviors()
    {
        $parent = parent::behaviors();

        $current = [
            'authenticator' => [
                'optional' => [
                    'menus'
                ]
            ],
            'access' => [
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['menus'],
                        'roles' => ['?'],
                    ],
                ]
            ]
        ];

        $behaviors = ArrayHelper::merge($parent, $current);

        return $behaviors;
    }
}
