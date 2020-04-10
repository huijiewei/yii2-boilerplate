<?php

namespace app\core\validators;

use app\core\helpers\StringHelper;
use yii\base\Model;
use yii\validators\Validator;

class PhoneNumberValidator extends Validator
{
    public $phoneNumber;

    public function init()
    {
        parent::init();

        if ($this->message == null) {
            $this->message = '{attribute}格式无效';
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);

        /** @var Model $model */
        if (!$model->hasErrors($attribute)) {
            $model->$attribute = $this->phoneNumber;
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (is_array($value)) {
            $value = implode('', $value);
        }

        if (!StringHelper::isPhoneNumber($value)) {
            return [$this->message, []];
        }

        $this->phoneNumber = $value;

        return null;
    }
}
