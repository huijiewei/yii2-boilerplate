<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 23:34
 */

namespace app\modules\admin\api\controllers;

use app\core\models\user\User;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;

class UserController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find()->orderBy(['id' => SORT_DESC]),
        ]);
    }

    public function actionCreate()
    {
        return ['userCreate'];
    }

}
