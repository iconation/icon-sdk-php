<?php

use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class SerializerTest extends TestCase
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
        $var = new iconation\IconSDK\IconService($this->icon_service_URL_main);
        $this->assertTrue(is_object($var));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_serializer()
    {

        $transaction = new \iconation\IconSDK\TransactionBuilder();
        $transaction = $transaction
            ->method(\iconation\IconSDK\TransactionTypes::SEND_TRANSACTION)
            ->from('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160')
            ->to('hxf8689d6c4c8f333651469fdea2ac59a18f6c242d')
            ->value('0x2386f26fc10000')
            ->version('0x3')
            ->nid()
            ->stepLimit()
            ->nonce('0x1')
            ->get();

        $result = \iconation\IconSDK\Utils\Serializer::serialize($transaction);
        $this->assertEquals('icx_sendTransaction.from.hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160.nid.0x1'.
            '.nonce.0x1.stepLimit.0x186a0.to.hxf8689d6c4c8f333651469fdea2ac59a18f6c242d.value.0x2386f26fc10000'.
            '.version.0x3', $result);
        unset($var);
    }
}
