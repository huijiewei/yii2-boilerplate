<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:16
 */

namespace app\modules\admin\api\controllers\adminGroup;

use app\modules\admin\api\ControllerAction;

class IndexAction extends ControllerAction
{
    public function run()
    {
        return ['message' => '测试'];
    }
}
