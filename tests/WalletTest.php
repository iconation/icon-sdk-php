<?php

use iconation\IconSDK\Utils\Helpers;
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
    public string $privateKey="3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
    public string $publicKey="c818b3d2ddeb6f29aaba7a85f113e057fb6ad3c522710d9831ef9501d477dff4c29b5585ce412edaf6702faa13b8ab78fcf166b853dcbaf3fed7eefbec0461ce";
    public string $publicAddress ="hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

    public function test_construct(){
        // Create a new wallet
        $wallet = new Wallet();

        $privateKey = $wallet->getPrivateKey();
        $publicKey = $wallet->getPublicKeyFromPrivate(privateKey: $privateKey);
        $publicAddress = $wallet->pubKeyToAddress(publicKey: $publicKey);

        $this->assertTrue($wallet->getPublicKey() === $publicKey);
        $this->assertTrue($wallet->getPublicAddress() === $publicAddress);
        unset($wallet);

        // Create a wallet from private key
        $wallet = new Wallet($this->privateKey);

        $this->assertTrue($wallet->getPrivateKey() === '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5');
        $this->assertTrue($wallet->getPublicKey() === 'c818b3d2ddeb6f29aaba7a85f113e057fb6ad3c522710d9831ef9501d477dff4c29b5585ce412edaf6702faa13b8ab78fcf166b853dcbaf3fed7eefbec0461ce');
        $this->assertTrue($wallet->getPublicAddress() === 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160');
        unset($wallet);

        // TODO Create a wallet from keystore
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
            new Wallet(privateKey: '123456');
        } catch (Exception $e) {
            $this->assertSame("Private key must be a 64 char hex string", $e->getMessage());
        }
    }

    public function test_getPublicKey()
    {
        $wallet = new Wallet;

        $key = $wallet->getPublicKeyFromPrivate(privateKey: $this->privateKey);
        $this->assertTrue(strlen($key) === 128);
        $this->assertTrue(ctype_xdigit($key));
        $this->assertSame($this->publicKey, $key);
        unset($wallet);
    }

    public function test_getPublicKeyWithWrongPrivateKey()
    {
        $wallet = new Wallet;

        try {
            $wallet->getPublicKeyFromPrivate(privateKey: "123345");
        } catch (Exception $e) {
            $this->assertSame("Private key must be a 64 char hex string", $e->getMessage());
        }
        unset($wallet);
    }

    public function test_pubkeyToAddress(){
        $wallet = new Wallet;

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $expectedAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $derived = $wallet->pubKeyToAddress(publicKey: $wallet->getPublicKeyFromPrivate(privateKey: $privateKey));
        $this->assertSame($expectedAddress, $derived);

        unset($wallet);
    }

    public function test_isPublicAddress(){

        $this->assertTrue(Helpers::isPublicAddress(address: $this->publicAddress));
        $this->assertFalse(Helpers::isPublicAddress(address: 'h'.$this->publicAddress));
        unset($helpers);
    }
}