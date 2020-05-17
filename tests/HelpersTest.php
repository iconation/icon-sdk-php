<?php

use PHPUnit\Framework\TestCase;
use iconation\IconSDK\Utils\Helpers;

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

    public function test_isPrivateKey(){
        $key = '1234567890123456789012345678901234567890123456789012345678abcdef';
        $this->assertTrue(Helpers::isPrivateKey($key));
        unset($var);
    }

    public function test_isPrivateKey_wrong_length(){
        $key = '1234567890123456789012345678901234567890';
        $this->assertFalse(Helpers::isPrivateKey($key));
        unset($var);
    }

    public function test_isPrivateKey_wrong_digits(){
        $key = '123456789012345678901234567890123456789012345678901234567890abcw';
        $this->assertFalse(Helpers::isPrivateKey($key));
        unset($var);
    }

    public function test_isPublicKey()
    {
        $key = '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012abcdef';
        $this->assertTrue(Helpers::isPublicKey($key));
        unset($var);
    }

    public function test_isPublicKey_wrong_length(){
        $key = '1234567890123456789012345678901234567890';
        $this->assertFalse(Helpers::isPublicKey($key));
        unset($var);
    }

    public function test_isPublicKey_wrong_digits(){
        $key = '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345abq';
        $this->assertFalse(Helpers::isPublicKey($key));
        unset($var);
    }

    public function test_isPublicAddress(){
        $address = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160';
        $this->assertTrue(Helpers::isPublicAddress($address));
        unset($var);
    }

    public function test_isPublicAddress_incorrect_prefix(){
        $address = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf616q';
        $this->assertFalse(Helpers::isPublicAddress($address));
        unset($var);
    }

    public function test_isPublicAddress_correct_prefix_wrong_suffix(){
        $address = '0x8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf616a';
        $this->assertFalse(Helpers::isPublicAddress($address));
        unset($var);
    }
}