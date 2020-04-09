<?php

namespace app\core\models;

class IdentityLogType
{
    public $value;
    public $description;

    /**
     * AdminLogType constructor.
     * @param $value
     * @param $description
     */
    public function __construct($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }
}
