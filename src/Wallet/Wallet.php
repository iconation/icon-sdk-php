<?php

namespace iconation\IconSDK\Wallet;

use Elliptic\EC;
use Exception;
use iconation\IconSDK\Utils\Helpers;

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
            $this->privateKey = $this->create();
        } else {
            $this->privateKey = $privateKey;
        }
        $this->publicKey = $this->getPublicKeyFromPrivate(privateKey: $this->privateKey);
        $this->publicAddress = $this->pubKeyToAddress(publicKey: $this->publicKey);
    }

    /**
     * @throws Exception
     */
    public function create(): string
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