<?php

use iconation\IconSDK\Utils\Helpers;
use iconation\IconSDK\Wallet\Wallet;
use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test Wallet class
 *
 *
 * @author Dimitris Frangiadakis
 */
class WalletTest extends TestCase
{
    public string $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
    public string $publicKey = "c818b3d2ddeb6f29aaba7a85f113e057fb6ad3c522710d9831ef9501d477dff4c29b5585ce412edaf6702faa13b8ab78fcf166b853dcbaf3fed7eefbec0461ce";
    public string $publicAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

    public function test_construct()
    {
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

    public function test_createFromKeystore()
    {
        $keystoreData = '{
          "version": 3,
          "id": "0617bf29-aa38-497f-81ca-2f06efd3d1f7",
          "address": "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160",
          "crypto": {
            "ciphertext": "50c0c97a088e0d94ab1ffb45ac42a99abb86f1226f21a31dfe14bbaed3758b4b",
            "cipherparams": {
              "iv": "1688eecedd2675a186b0086055b29947"
            },
            "cipher": "aes-128-ctr",
            "kdf": "scrypt",
            "kdfparams": {
              "dklen": 32,
              "salt": "61ded98497b08bc84313ba61cceb2105e8dab6882746379354dab9d080b683b7",
              "n": 16384,
              "r": 8,
              "p": 1
            },
            "mac": "1ef4779267e213f72e30f4f1673ff9026252c1f8fc1d66e39488d50e02f53319"
          },
          "coinType": "icx"
        }';
        $wallet = Wallet::createFromKeystore(keystoreData: $keystoreData, password: 'abc123123123%');
        assert($wallet instanceof Wallet);
        self::assertEquals($wallet->getPrivateKey(), $this->privateKey);


    }

    public function test_createFromKeystoreWrongPass()
    {
        $keystoreData = '{
          "version": 3,
          "id": "0617bf29-aa38-497f-81ca-2f06efd3d1f7",
          "address": "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160",
          "crypto": {
            "ciphertext": "50c0c97a088e0d94ab1ffb45ac42a99abb86f1226f21a31dfe14bbaed3758b4b",
            "cipherparams": {
              "iv": "1688eecedd2675a186b0086055b29947"
            },
            "cipher": "aes-128-ctr",
            "kdf": "scrypt",
            "kdfparams": {
              "dklen": 32,
              "salt": "61ded98497b08bc84313ba61cceb2105e8dab6882746379354dab9d080b683b7",
              "n": 16384,
              "r": 8,
              "p": 1
            },
            "mac": "1ef4779267e213f72e30f4f1673ff9026252c1f8fc1d66e39488d50e02f53319"
          },
          "coinType": "icx"
        }';
        try {
            Wallet::createFromKeystore(keystoreData: $keystoreData, password: 'abc123123123');
        } catch (Exception $e) {
            $this->assertSame("Invalid password", $e->getMessage());
        }
    }

    public function test_createFromKeystoreWrongKeystoreScheme()
    {
        $keystoreData = '{
          "version": 3,
          "id": "0617bf29-aa38-497f-81ca-2f06efd3d1f7",
          "address": "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160",
          "crypto": {
            "ciphertext": "50c0c97a088e0d94ab1ffb45ac42a99abb86f1226f21a31dfe14bbaed3758b4b",
            "cipherparams": {
              "iv": "1688eecedd2675a186b0086055b29947"
            },
            "cipher": "aes-128-ctr",
            "kdf": "pbkdf2",
            "kdfparams": {
              "dklen": 32,
              "salt": "61ded98497b08bc84313ba61cceb2105e8dab6882746379354dab9d080b683b7",
              "n": 16384,
              "r": 8,
              "p": 1
            },
            "mac": "1ef4779267e213f72e30f4f1673ff9026252c1f8fc1d66e39488d50e02f53319"
          },
          "coinType": "icx"
        }';
        try {
            Wallet::createFromKeystore(keystoreData: $keystoreData, password: 'abc123123123%');
        } catch (Exception $e) {
            $this->assertSame("Unsupported key derivation scheme", $e->getMessage());
        }
    }

    public function test_createFromInvalidKeystore()
    {
        try {
            Wallet::createFromKeystore(keystoreData: 'abc', password: 'abc123123123%');
        } catch (Exception $e) {
            $this->assertSame("Invalid keystore file", $e->getMessage());
        }
    }

    public function test_wallet_creation_with_wrong_private_key()
    {
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
        } catch (\Exception $e) {
            $this->assertSame("Private key must be a 64 char hex string", $e->getMessage());
        }
        unset($wallet);
    }

    public function test_pubkeyToAddress()
    {
        $wallet = new Wallet;

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $expectedAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $derived = $wallet->pubKeyToAddress(publicKey: $wallet->getPublicKeyFromPrivate(privateKey: $privateKey));
        $this->assertSame($expectedAddress, $derived);

        unset($wallet);
    }

    public function test_isPublicAddress()
    {

        $this->assertTrue(Helpers::isPublicAddress(address: $this->publicAddress));
        $this->assertFalse(Helpers::isPublicAddress(address: 'h' . $this->publicAddress));
        unset($helpers);
    }
}