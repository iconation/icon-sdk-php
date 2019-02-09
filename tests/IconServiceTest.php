<?php

use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class IconServiceTest extends TestCase
{

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    /*public function testIsThereAnySyntaxError()
    {
        $var = new mitsosf\IconSDK\IconService;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getLastBlock()
    {
        $var = new mitsosf\IconSDK\IconService;
        $this->assertTrue(!isset($var->icx_getLastBlock()->error));
        unset($var);
    }


    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHeight()
    {
        $var = new mitsosf\IconSDK\IconService;
        $height = "0x3";
        $this->assertTrue(!isset($var->icx_getBlockByHeight($height)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHash()
    {
        $var = new mitsosf\IconSDK\IconService;
        $hash = "0xb9c1edf5ad1c5d698e008d02ad12a90eb923839b2c690a993ed43102524b4f71";
        $this->assertTrue(!isset($var->icx_getBlockByHash($hash)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_call()
    {
        $var = new mitsosf\IconSDK\IconService;

        $from = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";
        $score = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
        $method = "balanceOf";
        $params = array(
            "_owner" => "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd"
        );

        $this->assertTrue(!isset($var->icx_call($from, $score, $method, $params)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBalance()
    {
        $var = new mitsosf\IconSDK\IconService;

        $address = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";
        $this->assertTrue(!isset($var->icx_getBalance($address)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getScoreApi()
    {
        $var = new mitsosf\IconSDK\IconService;

        $address = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
        $this->assertTrue(!isset($var->icx_getScoreApi($address)->error));
        unset($var);
    }

    public function test_icx_getTotalSupply()
    {
        $var = new mitsosf\IconSDK\IconService;

        $this->assertTrue(!isset($var->icx_getTotalSupply()->error));
        unset($var);
    }


    public function test_icx_getTransactionResult(){
        $var = new mitsosf\IconSDK\IconService;

        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($var->icx_getTransactionResult($txHash)->error));
        unset($var);
    }

    public function test_icx_getTransactionByHash(){
        $var = new mitsosf\IconSDK\IconService;

        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($var->icx_getTransactionByHash($txHash)->error));
        unset($var);
    }

    public function test_ise_getStatus(){
        $var = new mitsosf\IconSDK\IconService;

        $keys = ['lastBlock'];
        $this->assertTrue(!isset($var->ise_getStatus($keys)->error));
        unset($var);
    }

    //Not working for now
    /*
    public function test_debug_estimateStep(){
        $var = new mitsosf\IconSDK\IconService;

        $version = "0x3";
        $from = "hxc4193cda4a75526bf50896ec242d6713bb6b02a3";
        $to = "hxaa36c3e67d51f993a900fd5acf8b1eb5029c5dfd";
        $timestamp = "0x5c42da6830136";
        $value = "0xde0b6b3a7640000";

        fwrite(STDERR, print_r($var->debug_estimateStep($version, $from, $to, $timestamp, $value), TRUE));
        $this->assertTrue(!isset($var->debug_estimateStep($version, $from, $to, $timestamp, $value)->error));
        unset($var);
    }*/

    public function test_icx_sendTransaction()
    {
        $var = new mitsosf\IconSDK\IconService;

        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0xde0b6b3a7640000";
        $stepLimit = "0x186a0";
        $version = "0x3";
        $nid = "0x3";
        $test = $var->icx_sendTransaction($from, $to, $value, $stepLimit, $private_key, $version, $nid);
        var_dump($test);

        unset($var);

    }
}
