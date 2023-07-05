<?php

namespace iconation\IconSDK\IISS;

use iconation\IconSDK\Utils\Helpers;

class Bond extends Delegation {
    public function __construct(string $address, string $value)
    {
        parent::__construct($address, $value);
    }

    public function getBondObject(): \stdClass
    {
        $bond = new \stdClass();
        $bond->address = $this->address;
        $bond->value = $this->value;

        return $bond;
    }
}