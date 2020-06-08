<?php

use iconation\IconSDK\IISS\Delegation;
use PHPUnit\Framework\TestCase;
use iconation\IconSDK\Transaction\Transaction;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class DelegationTest extends TestCase
{
    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */

    public function testIsThereAnySyntaxError()
    {
        $address = 'hx123';
        $value = '1';
        $var = new Delegation($address, $value);
        $this->assertTrue(is_object($var));
        unset($var);
    }

    public function test_delegation()
    {
        $address = 'hx123';
        $value = '1';
        $hexValue = '0xde0b6b3a7640000';

        $delegation = new Delegation($address, $value);
        $this->assertSame($address, $delegation->getAddress());
        $this->assertSame($hexValue, $delegation->getValue());

        $newAddress = 'hx1234';
        $newValue = '2';
        $newHexValue = '0x1bc16d674ec80000';
        $delegation->setAddress($newAddress);
        $delegation->setValue($newValue);

        $this->assertSame($newAddress, $delegation->getAddress());
        $this->assertSame($newHexValue, $delegation->getValue());
    }
}