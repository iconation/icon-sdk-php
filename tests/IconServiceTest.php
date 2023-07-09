<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Wallet\Wallet;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class IconServiceTest extends TestCase
{
    private IconService $iconServiceMainnet;
    private IconService $iconServiceLisbon;
    private IconService $wrongIconService;

    private Wallet $wallet;

    public function __construct($name = 'IconServiceTest')
    {
        parent::__construct($name);
        $this->iconServiceMainnet = new IconService(url: 'https://ctz.solidwallet.io/api/v3');
        $this->iconServiceLisbon = new IconService(url: 'https://lisbon.net.solidwallet.io/api/v3');
        $this->wrongIconService = new IconService(url: 'https://wrong.net.solidwallet.io/api/v3');
        $this->wallet = new Wallet(privateKey: "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5");
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
        $this->assertTrue(is_object($this->iconServiceLisbon));

    }

    public function test_getLastBlock()
    {
        $this->assertTrue(!isset($this->iconServiceLisbon->getLastBlock()->error));
    }

    public function test_createIconService()
    {
        $this->assertInstanceOf(IconService::class, new IconService(url: 'https://ctz.solidwallet.io/api/v3'));
    }

    public function test_getBlockByHeight()
    {
        $height = "0x2";
        $this->assertTrue(!isset($this->iconServiceLisbon->getBlockByHeight(height: $height)->error));
    }

    public function test_getBlockByHash()
    {
        $hash = "0x123986e1c834632f6e65915c249d81cd01453ec915e3370d364d6df7be5e6c03";
        $this->assertTrue(!isset($this->iconServiceMainnet->getBlockByHash(hash: $hash)->error));
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_call()
    {
        $score = "cx273548dff8bb77ffaac5a342c4c04aeae0bc48fa";

        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";

        $this->assertTrue(!isset($this->iconServiceLisbon->call(score: $score, params: $params)->error));
    }

    public function test_getBalance()
    {
        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $this->assertTrue(!isset($this->iconServiceLisbon->getBalance(address: $address)->error));
    }

    public function test_getScoreApi()
    {
        $address = "cx273548dff8bb77ffaac5a342c4c04aeae0bc48fa";
        $this->assertTrue(!isset($this->iconServiceLisbon->getScoreApi(address: $address)->error));
    }

    public function test_getTotalSupply()
    {
        $this->assertTrue(!isset($this->iconServiceLisbon->getTotalSupply()->error));
    }


    public function test_getTransactionResult()
    {
        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $result = $this->iconServiceMainnet->getTransactionResult(txHash: $txHash);
        $this->assertTrue(!isset($result->error));
        $this->assertEquals('10.453448000000000000', $result->result->transactionFee);
    }

    public function test_getBlockByHeightWrongEndpoint()
    {
        $height = "0x2";
        try {
            $this->wrongIconService->getBlockByHeight(height: $height);
        } catch (Exception $e) {
            $this->assertStringContainsString("Error", $e->getMessage());
        }

    }

    public function test_sendTransactionWithTimeoutOnLisbon()
    {
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0.001"; // = 0.01 ICX
        $stepLimit = "0x186a0"; // = 100000 steps
        $nid = "0x2";  // Lisbon network


        $result = $this->iconServiceLisbon->sendAndWait(
            from: $this->wallet->getPublicAddress(),
            to: $to,
            value: $value,
            wallet: $this->wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
        $this->assertSame('MethodNotFound: NotEnabled(waitTimeout=0)', $result->error->message);
    }

    public function test_getTransactionByHash()
    {
        $txHash = "0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9";
        $this->assertTrue(!isset($this->iconServiceMainnet->getTransactionByHash(txHash: $txHash)->error));
    }

    public function test_debug_estimateStep()
    {
        $to = "hxaa36c3e67d51f993a900fd5acf8b1eb5029c5dfd";
        $value = "0xde0b6b3a7640000";

        $this->assertTrue(!isset($this->iconServiceLisbon->debug_estimateStep(
            from: $this->wallet->getPublicAddress(),
            to: $to,
            value: $value
            )->error));
    }

    public function test_send()
    {
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $value = "0.001"; // = 0.01 ICX
        $stepLimit = "0x186a0"; // = 100000 steps
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iconServiceLisbon->send(
            from: $this->wallet->getPublicAddress(),
            to: $to,
            value: $value,
            wallet: $this->wallet,
            stepLimit: $stepLimit,
            nid: $nid
            )->error));
    }
    //Commenting out until I find a contract to test against
    /* public function test_callSCORE()
     {
         //TODO properly test with contract
         $var = new IconService($this->icon_service_URL_Lisbon);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $to = "cxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x2";  // Lisbon network
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
         $var = new IconService($this->icon_service_URL_lisbon);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x2";  // Lisbon network
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
         $var = new IconService($this->icon_service_URL_lisbon);

         $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
         $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
         $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
         $stepLimit = "0x186a0"; // = 100000 steps
         $nid = "0x2";  // Lisbon network
         $score = "0xtestScoreData";
         $params = array(
             "amount" => "0x123"
         );

         $this->assertTrue(!isset($var->updateSCORE($from, $to, $stepLimit, $private_key, $score, $params, $nid)->error));
         unset($var);

     }*/

    public function test_message()
    {
        $to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
        $message = "[ICONation PHP SDK] Testing Messaging system";
        $stepLimit = "0xfffff"; // = 100000 steps
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iconServiceLisbon->message(
            from: $this->wallet->getPublicAddress(),
            to: $to,
            wallet: $this->wallet,
            message: $message,
            stepLimit: $stepLimit,
            nid: $nid
            )->error));
    }

    public function test_setIconServiceUrl()
    {
        $this->assertSame('https://ctz.solidwallet.io/api/v3', $this->iconServiceMainnet->getIconServiceUrl());

        $newUrl = 'test.url';
        $this->iconServiceMainnet->setIconServiceUrl($newUrl);
        $this->assertSame($newUrl, $this->iconServiceMainnet->getIconServiceUrl());
    }

}
