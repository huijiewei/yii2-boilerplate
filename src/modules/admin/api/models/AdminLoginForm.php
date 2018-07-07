<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 07:09
 */

namespace app\modules\admin\api\models;

use yii\base\Model;

class AdminLoginForm extends Model
{
    public $account;
    public $password;

    public function rules()
    {
        return [
            [['account', 'password'], 'trim'],
            [['account', 'password'], 'required'],
            [['account', 'password'], 'string'],
            ['account', 'validateAccount'],
            ['password', 'validatePassword']
        ];
    }

    protected function validateAccount($attribute)
    {
        $account = $this->$attribute;
    }
}
