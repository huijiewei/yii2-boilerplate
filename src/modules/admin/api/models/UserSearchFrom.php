<?php

namespace app\modules\admin\api\models;

use app\core\models\SearchForm;
use app\core\models\user\User;

class UserSearchFrom extends SearchForm
{
    public $phone;
    public $email;
    public $name;
    public $createdFrom;
    public $createdRange;

    public function searchRules()
    {
        return [
            [['createdFrom', 'createdRange', 'phone', 'email', 'name'], 'trim']
        ];
    }

    public function searchFields()
    {
        return [
            [
                'type' => 'keyword',
                'field' => 'phone',
                'label' => '电话',
            ],
            [
                'type' => 'keyword',
                'field' => 'email',
                'label' => '邮箱',
            ],
            [
                'type' => 'keyword',
                'field' => 'name',
                'label' => '姓名',
            ],
            [
                'type' => 'select',
                'field' => 'createdFrom',
                'label' => '注册来源',
                'multiple' => true,
                'options' => User::createdFromList(),
            ],
            [
                'type' => 'dateTimeRange',
                'field' => 'createdRange',
                'labelStart' => '注册开始日期',
                'labelEnd' => '注册结束日期',
                'rangeType' => 'daterange',
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
            'query' => $this->getQuery(),
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'text',
                ],
                [
                    'attribute' => 'phone',
                    'format' => 'text',
                ],
                [
                    'attribute' => 'email',
                    'format' => 'text',
                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                ],
                [
                    'label' => '注册来源',
                    'value' => function ($user) {
                        /* @var $user User */
                        return $user->getUserCreatedFrom()->description;
                    },
                ],
                [
                    'attribute' => 'createdIp',
                    'format' => 'text',
                ],
                [
                    'attribute' => 'createdAt',
                    'format' => 'datetime'
                ],
            ],
        ];
    }

    protected function getQuery()
    {
        $userQuery = User::find()->orderBy(['id' => SORT_DESC]);

        if (!empty($this->phone)) {
            $userQuery->andWhere(['LIKE', 'phone', $this->phone]);
        }

        if (!empty($this->email)) {
            $userQuery->andWhere(['LIKE', 'email', $this->email]);
        }

        if (!empty($this->name)) {
            $userQuery->andWhere(['LIKE', 'name', $this->name]);
        }

        if (!empty($this->createdFrom)) {
            $userQuery->andWhere(['createdFrom' => $this->createdFrom]);
        }

        if (
            !empty($this->createdRange)
            && is_array($this->createdRange)
            && count($this->createdRange) == 2
        ) {
            $userQuery->andWhere('createdAt >= :beginTime AND createdAt <= :endTime', [
                ':beginTime' => $this->createdRange[0] . ' 00:00:00',
                ':endTime' => $this->createdRange[1] . ' 23:59:59',
            ]);
        }

        return $userQuery;
    }
}
