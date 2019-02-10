<?php

use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test Wallet class
 *
 *
 * @author Dimitris Frangiadakis
 */
class WalletTest extends TestCase
{
    public $private_key="3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
    public $public_key="c818b3d2ddeb6f29aaba7a85f113e057fb6ad3c522710d9831ef9501d477dff4c29b5585ce412edaf6702faa13b8ab78fcf166b853dcbaf3fed7eefbec0461ce";
    public $public_address ="hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

    public function test_create()
    {
        $var = new mitsosf\IconSDK\Wallet;

        $key = $var->create();
        $this->assertTrue(strlen($key) === 64);
        $this->assertTrue(ctype_xdigit($key));
        unset($var);
    }

    public function test_getPublicKey()
    {
        $var = new mitsosf\IconSDK\Wallet;

        $key = $var->getPublicKey($this->private_key);
        $this->assertTrue(strlen($key) === 128);
        $this->assertTrue(ctype_xdigit($key));
        $this->assertSame($this->public_key, $key);
        unset($var);
    }

    public function test_pubkeyToAddress(){
        $var = new mitsosf\IconSDK\Wallet;

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $expectedAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $derived = $var->pubKeyToAddress($var->getPublicKey($privateKey));
        $this->assertSame($expectedAddress, $derived);

        unset($var);
    }
}