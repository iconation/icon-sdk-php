<?php

namespace iconation\IconSDK\Wallet;

use Elliptic\EC;
use Exception;
use iconation\IconSDK\Utils\Helpers;
use kornrunner\Keccak;

/**
 * @property string privateKey
 * @property string publicKey
 * @property string publicAddress
 */
class Wallet
{
    private string $privateKey;
    private string $publicKey;
    private string $publicAddress;

    /**
     * @throws Exception
     */
    function __construct($privateKey = null)
    {
        if (is_null($privateKey)) { // Generate wallet
            $this->privateKey = $this->generatePrivateKey();
        } else {
            $this->privateKey = $privateKey;
        }
        $this->publicKey = $this->getPublicKeyFromPrivate(privateKey: $this->privateKey);
        $this->publicAddress = $this->pubKeyToAddress(publicKey: $this->publicKey);
    }

    /**
     * @throws Exception
     */
    public static function createFromKeystore(string $keystoreData, string $password): Wallet
    {
        // Decode the keystore content into an array
        $keystore = json_decode($keystoreData);

        // Perform some basic validation
        if (!isset($keystore->crypto)) {
            throw new Exception('Invalid keystore file');
        }

        if ($keystore->crypto->kdf !== 'scrypt') {
            throw new Exception('Unsupported key derivation scheme');
        }

        // Derive the key from the password
        $kdfParams = $keystore->crypto->kdfparams;
        $derivedKey = scrypt(
            $password,
            hex2bin($kdfParams->salt),
            $kdfParams->n,
            $kdfParams->r,
            $kdfParams->p,
            $kdfParams->dklen
        );


        // Validate the derived key
        $validation = Keccak::hash(substr(pack('H*', $derivedKey),16, 16).pack('H*', $keystore->crypto->ciphertext), 256);
        if ($validation !== $keystore->crypto->mac) {
            throw new Exception('Invalid password');
        }

        $decryptedPrivateKey = openssl_decrypt(
            data: hex2bin($keystore->crypto->ciphertext),
            cipher_algo: strtoupper($keystore->crypto->cipher),
            passphrase: hex2bin($derivedKey),
            options: OPENSSL_RAW_DATA,
            iv: hex2bin($keystore->crypto->cipherparams->iv)
        );

        // Create a new Wallet instance from the decrypted private key
        return new self(privateKey: bin2hex($decryptedPrivateKey));
    }

    /**
     * @throws Exception
     */
    public function generatePrivateKey(): string
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $privateKey = '';
        for ($i = 0; $i < 64; $i++) {
                $privateKey .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $privateKey;
    }

    /**
     * @param string $privateKey
     * @return string
     * @throws Exception
     */
    public function getPublicKeyFromPrivate(string $privateKey): string
    {
        $ec = new EC('secp256k1');
        if (!Helpers::isPrivateKey(key: $privateKey)) {
            throw new Exception('Private key must be a 64 char hex string');
        }

        $publicKey = $ec->keyFromPrivate($privateKey)->getPublic(false, 'hex');
        return substr($publicKey, 2);
    }

    public function pubKeyToAddress(string $publicKey): string
    {
        return "hx" . substr(hash('sha3-256', hex2bin($publicKey)), -40);
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getPublicAddress(): string
    {
        return $this->publicAddress;
    }


}