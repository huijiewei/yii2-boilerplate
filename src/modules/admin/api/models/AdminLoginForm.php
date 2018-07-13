<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 07:09
 */

namespace app\modules\admin\api\models;

use app\core\helpers\StringHelper;
use app\core\models\admin\Admin;
use app\core\models\admin\AdminAccessToken;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class AdminLoginForm extends Model
{
    public $clientId;

    public $account;
    public $password;

    /* @var AdminAccessToken */
    public $accessToken;

    /* @var Admin|null */
    private $admin;

    public function init()
    {
        parent::init();

        if (empty($this->clientId)) {
            throw new InvalidArgumentException('初始化时请设置 clientId 属性');
        }
    }

    public function attributeLabels()
    {
        return [
            'account' => '管理员账号',
            'password' => '管理员密码',
        ];
    }

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

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->accessToken = $this->admin->generateAccessToken($this->clientId);

        \Yii::$app->getUser()->login($this->admin);

        return true;
    }

    public function validateAccount($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        $account = $this->$attribute;

        if (!StringHelper::isPhoneNumber($account)) {
            $this->addError($attribute, '无效的手机号码');

            return;
        }

        $admin = Admin::find()->where(['phone' => $account])->one();

        if ($admin == null) {
            $this->addError($attribute, '管理员: ' . $account . ' 不存在');

            return;
        }

        $this->admin = $admin;
    }

    public function validatePassword($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        $password = $this->$attribute;

        if (!$this->admin->validatePassword($password)) {
            $this->addError($attribute, '无效的管理员密码');

            return;
        }
    }
}
