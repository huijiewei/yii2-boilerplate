<?php

namespace app\modules\mobile\api\commands;

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
