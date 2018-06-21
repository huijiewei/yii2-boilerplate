<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/21
 * Time: 01:08
 */

namespace app\modules\admin\api\commands;

use yii\console\Controller;
use yii\helpers\Url;

class TestController extends Controller
{
    public $defaultAction = 'run';

    public function actionRun()
    {
        $url = Url::toRoute(['site/index']);

        var_dump($url);
    }
}
