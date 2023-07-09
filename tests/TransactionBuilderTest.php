<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
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
    private IconService $iconService;
    private TransactionBuilder $transactionBuilder;

    public function __construct($name = 'TransactionBuilderTest')
    {
        parent::__construct($name);
        $this->iconService = new IconService('https://lisbon.net.solidwallet.io/api/v3');
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object($this->transactionBuilder));
    }

    public function test_stepLimit_wrong_prefix(){
        $builder = $this->transactionBuilder;
        $limit = '1';
        $result = substr($builder->stepLimit($limit)->getTransaction()->getParams()->stepLimit,0, 2);
        $expected ='0x';
        $this->assertSame($expected, $result);
    }

    public function test_stepLimit(){

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0x2386f26fc10000"; // = 0.01 ICX
        $nid = "0x2";  // Lisbon network

        $transaction = $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->value($value)
            ->version('0x3')
            ->nid($nid)
            ->timestamp()
            ->nonce()
            ->stepLimit()
            ->get();

        $expectedStepLimit = '0x186a0';
        $resStepLimit = $transaction->getParams()->stepLimit;
        $this->assertSame($expectedStepLimit, $resStepLimit);
    }

    public function test_value(){
        $endpoint = '1';
        $builder = $this->transactionBuilder;
        $result = $builder->value($endpoint)->getTransaction()->getParams()->value;
        $this->assertSame('0xde0b6b3a7640000', $result);
    }

}