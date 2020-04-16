<?php

namespace app\modules\admin\api\models;

use app\core\models\admin\Admin;
use app\core\models\LoginForm;

class AdminLoginForm extends LoginForm
{
    public $captchaEnabled = true;

    protected function queryIdentity()
    {
        if ($this->accountType == static::ACCOUNT_TYPE_PHONE) {
            return Admin::findOne(['phone' => $this->account]);
        } else {
            return Admin::findOne(['email' => $this->account]);
        }
    }

    protected function getLoginRetryCachePrefix()
    {
        return 'AGILE-ADMIN';
    }
}
