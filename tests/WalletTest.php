<?php

use PHPUnit\Framework\TestCase;
use iconation\IconSDK\Wallet\Wallet;


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

    public function test_construct(){
        $wallet = new Wallet;

        $privateKey = $wallet->getPrivateKey();
        $publicKey = $wallet->getPublicKeyFromPrivate($privateKey);
        $publicAddress = $wallet->pubKeyToAddress($publicKey);

        $this->assertTrue($wallet->getPublicKey() === $publicKey);
        $this->assertTrue($wallet->getPublicAddress() === $publicAddress);
        unset($wallet);

        $wallet = new Wallet('d4b34071dc52970d8631674d2e5db510527be5ae08f47cc8212d05f8b0d7db5d');

        $this->assertTrue($wallet->getPrivateKey() === 'd4b34071dc52970d8631674d2e5db510527be5ae08f47cc8212d05f8b0d7db5d');
        $this->assertTrue($wallet->getPublicKey() === '9cf951e78c718208084bc9964a410064f78f724b15f39da67e26f3aed7450048c4e2aa8df3a0fa60eaa513a51740f2dff88dbf01c6bd9a17bb45eb907868542b');
        $this->assertTrue($wallet->getPublicAddress() === 'hx6365b257f4bc4697fac88862dbe0f6e1a263e6c6');
        unset($wallet);
    }

    public function test_create()
    {
        $wallet = new Wallet;

        $key = $wallet->create();
        $this->assertTrue(strlen($key) === 64);
        $this->assertTrue(ctype_xdigit($key));
        unset($wallet);
    }

    public function test_wallet_creation_with_wrong_private_key() {
        try {
            $wallet = new Wallet('123456');
        } catch (Exception $e) {
            $this->assertSame("Private key must be a 64 char hex string", $e->getMessage());
        }
    }

    public function test_getPublicKey()
    {
        $wallet = new Wallet;

        $key = $wallet->getPublicKeyFromPrivate($this->private_key);
        $this->assertTrue(strlen($key) === 128);
        $this->assertTrue(ctype_xdigit($key));
        $this->assertSame($this->public_key, $key);
        unset($wallet);
    }

    public function test_getPublicKeyWithWrongPrivateKey()
    {
        $wallet = new Wallet;

        try {
            $wallet->getPublicKeyFromPrivate("123345");
        } catch (Exception $e) {
            $this->assertSame("Private key must be a 64 char hex string", $e->getMessage());
        }
        unset($wallet);
    }

    public function test_pubkeyToAddress(){
        $wallet = new Wallet;

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $expectedAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $derived = $wallet->pubKeyToAddress($wallet->getPublicKeyFromPrivate($privateKey));
        $this->assertSame($expectedAddress, $derived);

        unset($wallet);
    }

    public function test_isPublicAddress(){
        $helpers = new \iconation\IconSDK\Utils\Helpers();

        $this->assertTrue($helpers->isPublicAddress($this->public_address));
        $this->assertFalse($helpers->isPublicAddress('h'.$this->public_address));
        unset($helpers);
    }
}