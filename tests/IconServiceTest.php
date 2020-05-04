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
    //Mainnet
    private $icon_service_URL_main = 'https://ctz.solidwallet.io/api/v3';
    //Yeouido
    private $icon_service_URL_yeouido = "https://bicon.net.solidwallet.io/api/v3";

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */

    public function testIsThereAnySyntaxError()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);
        $this->assertTrue(is_object($var));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getLastBlock()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);
        $this->assertTrue(!isset($var->icx_getLastBlock()->error));
        unset($var);
    }


    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHeight()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);
        $height = "0x3";
        $this->assertTrue(!isset($var->icx_getBlockByHeight($height)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getBlockByHash()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);
        $hash = "0x123986e1c834632f6e65915c249d81cd01453ec915e3370d364d6df7be5e6c03"; //Yeouido
        $this->assertTrue(!isset($var->icx_getBlockByHash($hash)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_call()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

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
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $address = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";
        $this->assertTrue(!isset($var->icx_getBalance($address)->error));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_icx_getScoreApi()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $address = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
        $this->assertTrue(!isset($var->icx_getScoreApi($address)->error));
        unset($var);
    }

    public function test_icx_getTotalSupply()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $this->assertTrue(!isset($var->icx_getTotalSupply()->error));
        unset($var);
    }


    public function test_icx_getTransactionResult()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($var->icx_getTransactionResult($txHash)->error));
        unset($var);
    }

    public function test_icx_getTransactionByHash()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($var->icx_getTransactionByHash($txHash)->error));
        unset($var);
    }

    public function test_ise_getStatus()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_main);

        $keys = ['lastBlock'];
        $this->assertTrue(!isset($var->ise_getStatus($keys)->error));
        unset($var);
    }

    //Not working for now

    /* public function test_debug_estimateStep(){
         $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

         $from = "hxc4193cda4a75526bf50896ec242d6713bb6b02a3";
         $to = "hxaa36c3e67d51f993a900fd5acf8b1eb5029c5dfd";
         $timestamp = "0x5c42da6830136";
         $value = "0xde0b6b3a7640000";

         $this->assertTrue(!isset($var->debug_estimateStep($from, $to, $timestamp, $value)->error));
         unset($var);
     }*/

    public function test_send()
    {
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0x2386f26fc10000"; // = 0.01 ICX
        $stepLimit = "0x186a0"; // = 100000 steps
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($var->send($from, $to, $value, $stepLimit, $private_key, $nid)->error));

        unset($var);

    }
    //Commenting out until I find a contract to test against
    /* public function test_callSCORE()
     {
         //TODO properly test with contract
         $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

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
         $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

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
         $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

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
        $var = new mitsosf\IconSDK\IconService($this->icon_service_URL_yeouido);

        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        //Test message
        $message = "Testing the Messaging system";
        $stepLimit = "0xfffff"; // = 100000 steps
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($var->message($from, $to, $stepLimit, $private_key, $message, "0x0", $nid)->error));
        unset($var);


    }

}
