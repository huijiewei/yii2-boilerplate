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
    public $createdFrom;
    public $createdRange;

    public function rules()
    {
        return array_merge([
            [['createdFrom', 'createdRange'], 'trim']
        ], parent::rules());
    }

    public function searchFields()
    {
        return [
            [
                'type' => 'keyword',
                'field' => 'phone',
                'label' => '电话号码',
            ],
            [
                'type' => 'keyword',
                'field' => 'display',
                'label' => '显示名',
            ],
            [
                'type' => 'select',
                'field' => 'createdFrom',
                'label' => '注册来源',
                'multiple' => true,
                'options' => User::createdFromNameList(),
            ],
            [
                'type' => 'dateRange',
                'field' => 'createdRange',
                'labelStart' => '注册开始日期',
                'labelEnd' => '注册结束日期',
            ],
            [
                'type' => 'br'
            ]
        ];
    }

    public function exportOptions()
    {
        return [
            'title' => '用户列表',
        ];
    }

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

        if (!empty($this->createdFrom)) {
            $userQuery->andWhere(['createdFrom' => $this->createdFrom]);
        }

        if (!empty($this->createdRange)
            && is_array($this->createdRange)
            && count($this->createdRange) == 2) {
            $userQuery->andWhere('createdAt >= :beginTime AND createdAt <= :endTime', [
                ':beginTime' => $this->createdRange[0] . ' 00:00:00',
                ':endTime' => $this->createdRange[1] . ' 23:59:59',
            ]);
        }

        return $userQuery;
    }
}
