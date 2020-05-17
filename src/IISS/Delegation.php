<?php

namespace iconation\IconSDK\IISS;

use iconation\IconSDK\Utils\Helpers;

class Delegation
{
    private $address;
    private $value;

    public function __construct(string $address, string $value)
    {
       $this->address = $address;
        if (substr($value,0,2) !== '0x'){
            $value = Helpers::icxToHex($value);
        }
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        if (substr($value,0,2) !== '0x'){
            $value = Helpers::icxToHex($value);
        }
        $this->value = $value;
    }

    public function getDelegationObject(){
        $delegation = new \stdClass();
        $delegation->address = $this->address;
        $delegation->value = $this->value;

        return $delegation;
    }
}