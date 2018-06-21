<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 23:29
 */

namespace app\modules\admin\api;

use app\core\components\RestController;
use yii\helpers\ArrayHelper;

class Controller extends RestController
{
    public function behaviors()
    {
        $parent = parent::behaviors();

        $behaviors = [
            'access' => [
                'rules' => [

                ]
            ]
        ];

        return ArrayHelper::merge($parent, $behaviors);
    }
}
