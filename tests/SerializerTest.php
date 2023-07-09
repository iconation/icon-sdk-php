<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\Transaction;
use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Serializer;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test IconService class
 *
 *
 * @author Dimitris Frangiadakis
 */
class SerializerTest extends TestCase
{
    private IconService $iconServiceMainnet;
    private TransactionBuilder $transactionBuilder;

    public function __construct($name = 'SerializerTest')
    {
        parent::__construct($name);
        $this->iconServiceMainnet = new IconService('https://ctz.solidwallet.io/api/v3');
        $this->transactionBuilder = new TransactionBuilder($this->iconServiceMainnet);
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
        $var = new Serializer();
        $this->assertTrue(is_object($var));
        unset($var);
    }

    //Check if error is returned
    //TODO Check if request is made properly, error doesn't mean that test should fail
    public function test_serializer()
    {
        $transaction = $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160')
            ->to('hxf8689d6c4c8f333651469fdea2ac59a18f6c242d')
            ->value('0x2386f26fc10000')
            ->version('0x2')
            ->nid()
            ->nonce('0x1')
            ->stepLimit('0x186a0')
            ->get();

        $result = \iconation\IconSDK\Utils\Serializer::serialize($transaction);
        $this->assertEquals('icx_sendTransaction.from.hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160.nid.0x1'.
            '.nonce.0x1.stepLimit.0x186a0.to.hxf8689d6c4c8f333651469fdea2ac59a18f6c242d.value.0x2386f26fc10000'.
            '.version.0x2', $result);
    }

    public function test_objTraverse()
    {
        // Set up reflection to access the private method
        $class = new ReflectionClass('\iconation\IconSDK\Utils\Serializer');
        $method = $class->getMethod('objTraverse');
        $method->setAccessible(true);

        // Test NULL value
        $obj = new \stdClass();
        $obj->data = null;
        $result = $method->invoke(null, $obj);
        $this->assertStringContainsString('data.\0', $result);

        // Test array value
        $obj->data = ['some_key' => 'some_value'];
        $result = $method->invoke(null, $obj);
        $this->assertStringContainsString('data.{some_key.some_value}', $result);

        // Test object value
        $obj->data = (object) ['some_key' => 'some_value'];
        $result = $method->invoke(null, $obj);
        $this->assertStringContainsString('data.{some_key.some_value}', $result);
    }

    public function testSerializeTransactionWithVariousData()
    {
        $iconServiceMock = $this->getMockBuilder(IconService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transaction = new Transaction($iconServiceMock);
        $transaction->setMethod('SEND_TRANSACTION');
        $params = array(
            'from' => 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
            'to' => 'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
            'value' => '0x2386f26fc10000',
            'version' => '0x2',
            'nid' => '0x1',
            'nonce' => '0x1',
            'stepLimit' => '0x186a0',
            'data' => array('some_key' => 'some_value')
        );
        $transaction->setParams($params);

        $serializedTransaction = Serializer::serialize($transaction, false);

        $this->assertStringContainsString('{some_key.some_value}', $serializedTransaction);

        $params = array(
            'from' => 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
            'to' => 'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
            'value' => '0x2386f26fc10000',
            'version' => '0x2',
            'nid' => '0x1',
            'nonce' => '0x1',
            'stepLimit' => '0x186a0',
            'data' => array(null)
        );

        $transaction->setParams($params);

        $serializedTransaction = Serializer::serialize($transaction, false);

        $this->assertStringContainsString('\0', $serializedTransaction);

        $params = array(
            'from' => 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
            'to' => 'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
            'value' => '0x2386f26fc10000',
            'version' => '0x2',
            'nid' => '0x1',
            'nonce' => '0x1',
            'stepLimit' => '0x186a0',
            'data' => array('testString')
        );

        $transaction->setParams($params);

        $serializedTransaction = Serializer::serialize($transaction, false);

        $this->assertStringContainsString('testString', $serializedTransaction);

        $params = array(
            'from' => 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
            'to' => 'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
            'value' => '0x2386f26fc10000',
            'version' => '0x2',
            'nid' => '0x1',
            'nonce' => '0x1',
            'stepLimit' => '0x186a0',
            'data' => array(array('other_key' => 'other_value'))
        );

        $transaction->setParams($params);

        $serializedTransaction = Serializer::serialize($transaction, false);

        $this->assertStringContainsString('{other_key.other_value}', $serializedTransaction);
    }
}
