<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\TransactionBuilder;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class TransactionBuilderTest extends TestCase
{
    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    private $iconService;
    private $transactionBuilder;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->iconService = new IconService('https://ctz.solidwallet.io/api/v3');
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object($this->transactionBuilder));
        unset($var);
    }

    public function test_stepLimit_wrong_prefix(){
        $builder = $this->transactionBuilder;
        $limit = '1';
        $result = substr($builder->stepLimit($limit)->getTransaction()->getParams()->stepLimit,0, 2);
        $expected ='0x';
        $this->assertSame($expected, $result);
        unset($var);
    }

    public function test_testnet(){
        $endpoint = 'test.net/endpoint';
        $builder = $this->transactionBuilder;
        $result = $builder->testnet($endpoint)->getTransaction()->getIconService()->getIconServiceUrl();
        $this->assertSame($endpoint, $result);
        unset($var);
    }

    public function test_value(){
        $endpoint = '1';
        $builder = $this->transactionBuilder;
        $result = $builder->value($endpoint)->getTransaction()->getParams()->value;
        $this->assertSame('0xde0b6b3a7640000', $result);
        unset($var);
    }

}