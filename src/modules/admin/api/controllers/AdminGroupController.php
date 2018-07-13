<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:15
 */

namespace app\modules\admin\api\controllers;

use app\core\models\admin\AdminGroup;
use app\modules\admin\api\Controller;
use yii\data\ActiveDataProvider;

class AdminGroupController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => AdminGroup::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);
    }
}
