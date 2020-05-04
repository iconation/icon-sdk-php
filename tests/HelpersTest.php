<?php

use PHPUnit\Framework\TestCase;
use mitsosf\IconSDK\Helpers;

class HelpersTest extends TestCase{

    public function test_icxToHex(){
        $result = '0x2386f26fc10000';
        $this->assertTrue(Helpers::icxToHex(0.01) === $result);
        unset($var);
    }

    public function test_hexToIcx(){
        $result = 0.01;
        $this->assertTrue(Helpers::hexToIcx('0x2386f26fc10000') === $result);
        unset($var);
    }
}