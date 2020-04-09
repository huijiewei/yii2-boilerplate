<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/28
 * Time: 16:14
 */

namespace app\modules\admin\api\models;

use app\core\models\SearchForm;
use app\core\models\shop\ShopBrand;

class ShopBrandSearchForm extends SearchForm
{
    public $name;

    public $isPagination = false;

    /**
     * @return array|null
     */
    public function searchFields()
    {
        return [
            [
                'type' => 'keyword',
                'field' => 'name',
                'label' => '品牌',
            ]
        ];
    }

    public function searchRules()
    {
        return [
            [['name'], 'trim']
        ];
    }

    public function exportOptions()
    {
        return null;
    }

    protected function getQuery()
    {
        $shopBrandQuery = ShopBrand::find()->with(['shopCategories'])->orderBy(['id' => SORT_ASC]);

        if (!empty($this->name)) {
            $shopBrandQuery->andWhere(['LIKE', 'name', $this->name]);
        }

        return $shopBrandQuery;
    }
}
