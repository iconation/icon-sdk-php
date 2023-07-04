<?php

use iconation\IconSDK\Transaction\TransactionBuilder;
use PHPUnit\Framework\TestCase;
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\Transaction;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class TransactionTest extends TestCase
{
    private $iconservice;
    private $transaction;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
        $this->transaction = new Transaction($this->iconservice);
    }

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object($this->transaction));
    }

    public function test_setJsonRpc()
    {
        $jsonrpc = '5.0';
        $this->transaction->setJsonrpc($jsonrpc);
        $this->assertSame($jsonrpc, $this->transaction->getJsonrpc());
    }

    public function test_setId()
    {
        $id = 1234567;
        $this->transaction->setId($id);
        $this->assertSame($id, $this->transaction->getId());
    }

    public function test_getTransactionParamsObject_empty_params()
    {
        $this->assertNull($this->transaction->getTransactionParamsObject());
    }

    public function test_getTransactionParamsArray(){
        //First check when no param is set
        $this->assertNull($this->transaction->getTransactionParamsArray());

        //Now set an arbitrary param
        $paramsArray = ['test'=>'test'];
        $this->transaction->setParams($paramsArray);
        $this->assertNotNull($this->transaction->getTransactionParamsArray());
        $this->assertSame($paramsArray, $this->transaction->getTransactionParamsArray());
    }

    public function test_getIconservice(){
        $this->assertInstanceOf(IconService::class, $this->transaction->getIconService());
    }
}