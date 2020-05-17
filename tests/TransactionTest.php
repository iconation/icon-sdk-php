<?php

use PHPUnit\Framework\TestCase;
use iconation\IconSDK\Transaction\Transaction;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class TransactionTest extends TestCase
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
        $var = new Transaction();
        $this->assertTrue(is_object($var));
        unset($var);
    }

    public function test_setJsonRpc()
    {
        $transaction = new Transaction();
        $jsonrpc = '5.0';
        $transaction->setJsonrpc($jsonrpc);
        $this->assertSame($jsonrpc, $transaction->getJsonrpc());
        unset($transaction);
    }

    public function test_setId()
    {
        $transaction = new Transaction();
        $id = 1234567;
        $transaction->setId($id);
        $this->assertSame($id, $transaction->getId());
        unset($transaction);
    }

    public function test_value()
    {
        $transaction = new Transaction();
        $value = '0x123';
        $transaction->setValue($value);
        $this->assertSame($value, $transaction->getValue());
        unset($transaction);
    }

    public function test_getTransactionParamsObject_empty_params()
    {
        $transaction = new Transaction();
        $this->assertNull($transaction->getTransactionParamsObject());
        unset($transaction);
    }

    public function test_getTransactionParamsArray(){
        //First check when no param is set
        $transaction = new Transaction();
        $this->assertNull($transaction->getTransactionParamsArray());

        //Now set an arbitrary param
        $paramsArray = ['test'=>'test'];
        $transaction->setParams($paramsArray);
        $this->assertNotNull($transaction->getTransactionParamsArray());
        $this->assertSame($paramsArray, $transaction->getTransactionParamsArray());
    }
}