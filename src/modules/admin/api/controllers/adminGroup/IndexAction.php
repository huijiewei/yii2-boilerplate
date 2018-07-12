<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/11
 * Time: 19:16
 */

namespace app\modules\admin\api\controllers\adminGroup;

use app\core\models\admin\AdminGroup;
use app\modules\admin\api\ControllerAction;
use yii\data\ActiveDataProvider;

class IndexAction extends ControllerAction
{
    public function run()
    {
        return new ActiveDataProvider([
            'query' => AdminGroup::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => null,
        ]);
    }
}
