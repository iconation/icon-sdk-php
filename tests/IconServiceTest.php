<?php

use iconation\IconSDK\IconService\IconService;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class IconServiceTest extends TestCase
{
    private $iconServiceMainnet;
    private $iconServiceYeouido;
    private $iconServiceDebugMainnet;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->iconServiceMainnet = new IconService('https://ctz.solidwallet.io/api/v3');
        $this->iconServiceDebugMainnet = new IconService('https://ctz.solidwallet.io/api/debug/v3');
        $this->iconServiceYeouido = new IconService('https://bicon.net.solidwallet.io/api/v3');
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
        $this->assertTrue(is_object($this->iconServiceMainnet));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getLastBlock()
    {
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getLastBlock()->error));
    }


    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHeight()
    {
        $height = "0x3";
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getBlockByHeight($height)->error));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHash()
    {
        $hash = "0x123986e1c834632f6e65915c249d81cd01453ec915e3370d364d6df7be5e6c03"; //Yeouido
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getBlockByHash($hash)->error));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_call()
    {
        $score = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";

        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";

        $this->assertTrue(!isset($this->iconServiceMainnet->icx_call($score, $params)->error));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBalance()
    {
        $address = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getBalance($address)->error));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getScoreApi()
    {
        $address = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getScoreApi($address)->error));
    }

    public function test_icx_getTotalSupply()
    {
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getTotalSupply()->error));
    }


    public function test_icx_getTransactionResult()
    {
        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getTransactionResult($txHash)->error));
    }

    public function test_icx_getTransactionByHash()
    {
        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($this->iconServiceMainnet->icx_getTransactionByHash($txHash)->error));
    }

    public function test_ise_getStatus()
    {
        $keys = ['lastBlock'];
        $this->assertTrue(!isset($this->iconServiceMainnet->ise_getStatus($keys)->error));
    }

    //Not working for now

    public function test_debug_estimateStep()
    {
        $from = "hxc4193cda4a75526bf50896ec242d6713bb6b02a3";
        $to = "hxaa36c3e67d51f993a900fd5acf8b1eb5029c5dfd";
        $timestamp = "0x5c42da6830136";
        $value = "0xde0b6b3a7640000";

        $this->assertTrue(!isset($this->iconServiceDebugMainnet->debug_estimateStep($from, $to, $timestamp, $value)->error));
        unset($var);
    }

    public function test_send()
    {
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0x2386f26fc10000"; // = 0.01 ICX
        $stepLimit = "0x186a0"; // = 100000 steps
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($this->iconServiceYeouido->send($from, $to, $value, $stepLimit, $private_key, $nid)->error));
    }
    //Commenting out until I find a contract to test against
    /* public function test_callSCORE()
     {
         //TODO properly test with contract
         $var = new IconService($this->icon_service_URL_yeouido);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $to = "cxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x3";  // YEOUIDO network
         $method = "tranfer";
         $params = array(
             "to" => "hxmyAss",
             "value" => "0x1231"
         );

         $this->assertTrue(!isset($var->callSCORE($from, $to, $stepLimit, $private_key, $method, $params, $nid)->error));
         unset($var);
     }

     public function test_installSCORE()
     {
         //TODO properly test with contract
         $var = new IconService($this->icon_service_URL_yeouido);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x3";  // YEOUIDO network
         $score = "0xtestScoreData";
         $params = array(
             "name" => "TestTokenn",
             "symbol" => "tst",
             "decimals" => "0x12"  //18
         );

         $this->assertTrue(!isset($var->installSCORE($from, $stepLimit, $private_key, $score, $params, $nid)->error));
         unset($var);

     }

     public function test_updateSCORE()
     {
         //TODO properly test with contract
         $var = new IconService($this->icon_service_URL_yeouido);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x3";  // YEOUIDO network
         $score = "0xtestScoreData";
         $params = array(
             "amount" => "0x123"
         );

         $this->assertTrue(!isset($var->updateSCORE($from, $to, $stepLimit, $private_key, $score, $params, $nid)->error));
         unset($var);

     }*/

    public function test_message()
    {
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        //Test message
        $message = "[ICONation PHP SDK] Testing Messaging system";
        $stepLimit = "0xfffff"; // = 100000 steps
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($this->iconServiceYeouido->message($from, $to, $stepLimit, $private_key, $message, "0x0", $nid)->error));
    }

    public function test_setIconServiceUrl()
    {
        $this->assertSame('https://ctz.solidwallet.io/api/v3', $this->iconServiceMainnet->getIconServiceUrl());

        $newUrl = 'test.url';
        $this->iconServiceMainnet->setIconServiceUrl($newUrl);
        $this->assertSame($newUrl, $this->iconServiceMainnet->getIconServiceUrl());
    }

}
