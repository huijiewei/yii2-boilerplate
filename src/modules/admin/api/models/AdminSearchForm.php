<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/28
 * Time: 16:14
 */

namespace app\modules\admin\api\models;

use app\core\models\admin\Admin;
use app\core\models\SearchForm;

class AdminSearchForm extends SearchForm
{
    public $isPagination = false;

    /**
     * @return array|null
     */
    public function searchFields()
    {
        return null;
    }

    public function searchRules()
    {
        return [];
    }

    public function exportOptions()
    {
        return null;
    }

    protected function getQuery()
    {
        return Admin::find()->with(['adminGroup'])->orderBy(['id' => SORT_ASC]);
    }
}
