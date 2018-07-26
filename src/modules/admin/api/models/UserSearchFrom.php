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
    public $createdAt;
    public $createdFrom;
    public $createdRange;

    public function rules()
    {
        return array_merge([
            [['createdAt', 'createdFrom', 'createdRange'], 'trim']
        ], parent::rules());
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

        if (!empty($this->createdAt)) {
            $userQuery->andWhere(['DATE(createdAt)' => $this->createdAt]);
        }

        if (!empty($this->createdFrom)) {
            $userQuery->andWhere(['createdFrom' => $this->createdFrom]);
        }

        if (!empty($this->createdRange)
            && is_array($this->createdRange)
            && count($this->createdRange) == 2) {
            $userQuery->andWhere('createdAt >= :beginTime AND createdAt <= :endTime', [
                ':beginTime' => $this->createdRange[0],
                ':endTime' => $this->createdRange[1],
            ]);
        }

        return $userQuery;
    }

    protected function searchFields()
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
                'type' => 'date',
                'field' => 'createdAt',
                'label' => '注册日期',
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
}
