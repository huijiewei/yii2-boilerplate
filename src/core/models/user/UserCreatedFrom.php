<?php

namespace app\core\models\user;

class UserCreatedFrom
{
    public $value;
    public $description;

    /**
     * UserCreatedFrom constructor.
     * @param $value
     * @param $description
     */
    public function __construct($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }
}
