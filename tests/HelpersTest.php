<?php

use iconation\IconSDK\Utils\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{

    public function test_icxToHex()
    {
        $result = '0x8ac7230489e80001';
        $this->assertTrue(Helpers::icxToHex('10.000000000000000001') === $result);
    }

    public function test_hexToIcx()
    {
        $result = '10.000000000000000001';
        $this->assertTrue(Helpers::hexToIcx('0x8ac7230489e80001') === $result);
    }

    public function test_hexToIcx2()
    {
        $result = '0.000000010000000000';
        $this->assertTrue(Helpers::hexToIcx('0x2540be400') === $result);
    }

    public function test_isPrivateKey()
    {
        $key = '1234567890123456789012345678901234567890123456789012345678abcdef';
        $this->assertTrue(Helpers::isPrivateKey($key));
    }

    public function test_isPrivateKey_wrong_length()
    {
        $key = '1234567890123456789012345678901234567890';
        $this->assertFalse(Helpers::isPrivateKey($key));
    }

    public function test_isPrivateKey_wrong_digits()
    {
        $key = '123456789012345678901234567890123456789012345678901234567890abcw';
        $this->assertFalse(Helpers::isPrivateKey($key));
    }

    public function test_isPublicKey()
    {
        $key = '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012abcdef';
        $this->assertTrue(Helpers::isPublicKey($key));
    }

    public function test_isPublicKey_wrong_length()
    {
        $key = '1234567890123456789012345678901234567890';
        $this->assertFalse(Helpers::isPublicKey($key));
    }

    public function test_isPublicKey_wrong_digits()
    {
        $key = '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345abq';
        $this->assertFalse(Helpers::isPublicKey($key));
    }

    public function test_isPublicAddress()
    {
        $address = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160';
        $this->assertTrue(Helpers::isPublicAddress($address));
    }

    public function test_isPublicAddress_incorrect_prefix()
    {
        $address = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf616q';
        $this->assertFalse(Helpers::isPublicAddress($address));
    }

    public function test_isPublicAddress_correct_prefix_wrong_suffix()
    {
        $address = '0x8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf616a';
        $this->assertFalse(Helpers::isPublicAddress($address));
    }
}