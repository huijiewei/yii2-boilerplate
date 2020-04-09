<?php

namespace app\core\models;

class IdentityLogStatus
{
    public $value;
    public $description;

    /**
     * AdminLogStatus constructor.
     * @param $value
     * @param $description
     */
    public function __construct($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }
}
