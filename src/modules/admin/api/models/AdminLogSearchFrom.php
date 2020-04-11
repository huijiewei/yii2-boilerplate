<?php

namespace app\modules\admin\api\models;

use app\core\models\admin\Admin;
use app\core\models\admin\AdminLog;
use app\core\models\SearchForm;

class AdminLogSearchFrom extends SearchForm
{
    public $admin;
    public $type;
    public $status;
    public $createdRange;

    public function searchRules()
    {
        return [
            [['admin', 'createdRange', 'type', 'status'], 'trim']
        ];
    }

    public function searchFields()
    {
        return [
            [
                'type' => 'keyword',
                'field' => 'admin',
                'label' => '管理员',
            ],
            [
                'type' => 'keyword',
                'field' => 'email',
                'label' => '邮箱',
            ],
            [
                'type' => 'select',
                'field' => 'type',
                'label' => '日志类型',
                'multiple' => true,
                'options' => AdminLog::typeList(),
            ],
            [
                'type' => 'select',
                'field' => 'status',
                'label' => '操作状态',
                'multiple' => false,
                'options' => AdminLog::statusList(),
            ],
            [
                'type' => 'dateTimeRange',
                'field' => 'createdRange',
                'labelStart' => '开始日期',
                'labelEnd' => '结束日期',
                'rangeType' => 'daterange',
            ],
            [
                'type' => 'br'
            ]
        ];
    }

    public function exportOptions()
    {
        return null;
    }

    protected function getQuery()
    {
        $adminLogQuery = AdminLog::find()->orderBy(['id' => SORT_DESC]);

        if (!empty($this->admin)) {
            $adminLogQuery->andWhere([
                'adminId' => Admin::find()
                    ->where([
                        'OR',
                        ['LIKE', 'name', $this->admin],
                        ['LIKE', 'phone', $this->admin],
                        ['LIKE', 'email', $this->admin]
                    ])
                    ->select('id')
            ]);
        }

        if (!empty($this->type)) {
            $adminLogQuery->andWhere(['type' => $this->type]);
        }


        if ($this->status != null) {
            $adminLogQuery->andWhere(['status' => $this->status]);
        }

        if (
            !empty($this->createdRange)
            && is_array($this->createdRange)
            && count($this->createdRange) == 2
        ) {
            $adminLogQuery->andWhere('createdAt >= :beginTime AND createdAt <= :endTime', [
                ':beginTime' => $this->createdRange[0] . ' 00:00:00',
                ':endTime' => $this->createdRange[1] . ' 23:59:59',
            ]);
        }

        return $adminLogQuery;
    }
}
