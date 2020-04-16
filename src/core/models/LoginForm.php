<?php

namespace app\core\models;

use app\core\components\Model;
use app\core\models\captcha\Captcha;
use app\core\validators\PhoneNumberValidator;
use yii\base\InvalidArgumentException;
use yii\validators\EmailValidator;

abstract class LoginForm extends Model
{
    public const ACCOUNT_TYPE_EMAIL = 'EMAIL';
    public const ACCOUNT_TYPE_PHONE = 'PHONE';

    public $captchaEnabled = true;

    public $clientId;

    public $userAgent;
    public $remoteAddr;

    public $account;
    public $password;
    public $captcha;

    public $accountInvalidTypeMessage = '无效的帐号,帐号应该是邮箱地址或者手机号码';
    public $accountNotExistMessage = '账号不存在';
    public $passwordErrorMessage = '密码输入错误';
    public $captchaNeedMessage = '请输入验证码';
    public $captchaErrorMessage = '验证码输入错误';

    /* @var $accessToken string */
    public $accessToken = '';

    protected $accountType = false;

    /* @var $identity Identity */
    private $identity = null;

    public function init()
    {
        parent::init();

        if (empty($this->clientId)) {
            throw new InvalidArgumentException('初始化时请设置 clientId 属性');
        }
    }

    public function rules()
    {
        return [
            [['account', 'password', 'captcha'], 'trim'],
            [['account', 'password'], 'required'],
            [['account', 'password', 'captcha'], 'string'],
            ['account', 'validateAccount'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'account' => '账号',
            'password' => '密码',
            'captcha' => '验证码'
        ];
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->accessToken = $this->identity->generateAccessToken($this->clientId);

        \Yii::$app->getUser()->login($this->identity);

        $this->afterLogin($this->identity);

        return true;
    }

    /**
     * @param $identity Identity
     */
    protected function afterLogin($identity)
    {
    }

    public function validateAccount($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        $account = $this->$attribute;

        $emailValidator = new EmailValidator();

        if ($emailValidator->validate($account)) {
            $this->account = static::ACCOUNT_TYPE_EMAIL;
        }

        $phoneValidator = new PhoneNumberValidator();

        if ($phoneValidator->validate($account)) {
            $this->accountType = static::ACCOUNT_TYPE_PHONE;
        }

        if ($this->accountType === false) {
            $this->addError($attribute, $this->accountInvalidTypeMessage);

            return;
        }

        $retryKey = '';
        $retryTimes = 0;

        if ($this->captchaEnabled) {
            $retryKey = substr(md5($this->clientId . '-' . $this->remoteAddr), 0, 8);
            $retryTimes = $this->getLoginRetryTimes($retryKey);

            if ($retryTimes > 3 && !$this->validateCaptcha()) {
                return;
            }
        }

        $this->identity = $this->queryIdentity();

        if ($this->identity == null) {
            $this->addError($attribute, $this->accountNotExistMessage);

            if ($this->captchaEnabled) {
                if ($retryTimes >= 2) {
                    $this->addError('captcha', '');
                }

                $this->setLoginRetryTimes($retryKey, $retryTimes + 1);
            }

            return;
        }

        if ($this->captchaEnabled) {
            $this->deleteLoginRetryTimes($retryKey);
        }
    }

    private function getLoginRetryTimes($key)
    {
        $loginRetryTimes = \Yii::$app->getCache()->get($this->getLoginRetryCachePrefix() . '-' . $key);

        if ($loginRetryTimes == false) {
            $loginRetryTimes = 0;
        }

        return $loginRetryTimes;
    }

    abstract protected function getLoginRetryCachePrefix();

    private function validateCaptcha()
    {
        if (empty($this->captcha)) {
            $this->addError('captcha', $this->captchaNeedMessage);

            return false;
        }

        $captchaSplit = explode('_', $this->captcha);

        if (count($captchaSplit) != 2) {
            $this->addError('captcha', $this->captchaErrorMessage);

            return false;
        }

        /* @var $captcha Captcha|null */
        $captcha = Captcha::find()
            ->where([
                'code' => $captchaSplit[0],
                'uuid' => $captchaSplit[1],
                'userAgent' => $this->userAgent,
                'remoteAddr' => $this->remoteAddr
            ])
            ->one();

        if ($captcha == null) {
            $this->addError('captcha', $this->captchaErrorMessage);

            return false;
        }

        $captcha->delete();

        return true;
    }

    /**
     * @return Identity
     */
    abstract protected function queryIdentity();

    private function setLoginRetryTimes($key, $times)
    {
        \Yii::$app->getCache()->set($this->getLoginRetryCachePrefix() . '-' . $key, $times);
    }

    private function deleteLoginRetryTimes($key)
    {
        \Yii::$app->getCache()->delete($this->getLoginRetryCachePrefix() . '-' . $key);
    }

    public function validatePassword($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        $retryKey = '';
        $retryTimes = 0;

        if ($this->captchaEnabled) {
            $retryKey = $this->identity->id;
            $retryTimes = $this->getLoginRetryTimes($retryKey);

            if ($retryTimes > 3 && !$this->validateCaptcha()) {
                return;
            }
        }

        $identityLog = $this->identity->createLog();

        if ($identityLog != null) {
            $identityLog->type = IdentityLog::TYPE_LOGIN;
            $identityLog->remoteAddr = $this->remoteAddr;
            $identityLog->userAgent = $this->userAgent;
            $identityLog->method = 'POST';
            $identityLog->action = 'Login';
        }

        $password = $this->$attribute;

        if (!$this->identity->validatePassword($password)) {
            $this->addError($attribute, $this->passwordErrorMessage);

            if ($this->captchaEnabled) {
                if ($retryTimes >= 2) {
                    $this->addError('captcha', '');
                }

                $this->setLoginRetryTimes($retryKey, $retryTimes + 1);
            }

            if ($identityLog != null) {
                $identityLog->status = IdentityLog::STATUS_FAIL;
                $identityLog->exception = '密码错误';
                $identityLog->save(false);
            }

            return;
        }

        if ($this->captchaEnabled) {
            $this->deleteLoginRetryTimes($retryKey);
        }

        if ($identityLog != null) {
            $identityLog->status = IdentityLog::STATUS_SUCCESS;
            $identityLog->save(false);
        }
    }
}
