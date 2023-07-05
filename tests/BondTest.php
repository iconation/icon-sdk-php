<?php

use iconation\IconSDK\IISS\Bond;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class BondTest extends TestCase
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
        $var = new Bond($address, $value);
        $this->assertTrue(is_object($var));
        unset($var);
    }

    public function test_bond()
    {
        $address = 'hx123';
        $value = '1';
        $hexValue = '0xde0b6b3a7640000';

        $bond = new Bond($address, $value);
        $this->assertSame($address, $bond->getAddress());
        $this->assertSame($hexValue, $bond->getValue());

        $newAddress = 'hx1234';
        $newValue = '2';
        $newHexValue = '0x1bc16d674ec80000';
        $bond->setAddress($newAddress);
        $bond->setValue($newValue);

        $this->assertSame($newAddress, $bond->getAddress());
        $this->assertSame($newHexValue, $bond->getValue());
    }
}