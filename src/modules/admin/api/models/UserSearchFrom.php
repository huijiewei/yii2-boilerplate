<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/26
 * Time: 10:15
 */

namespace app\modules\admin\api\models;

use app\core\models\SearchForm;
use app\core\models\user\User;

class UserSearchFrom extends SearchForm
{
    protected function getQuery()
    {
        $userQuery = User::find()->orderBy(['id' => SORT_DESC]);

        if (!empty($this->keyword)) {
            if ($this->field === 'phone') {
                $userQuery->andWhere(['like', 'phone', $this->keyword]);
            }

            if ($this->field === 'display') {
                $userQuery->andWhere(['like', 'display', $this->keyword]);
            }
        }

        return $userQuery;
    }

    protected function searchFields()
    {
        return [
            [
                'field' => 'phone',
                'label' => '电话号码',
            ],
            [
                'field' => 'display',
                'label' => '显示名',
            ],
        ];
    }
}
