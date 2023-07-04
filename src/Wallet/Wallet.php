<?php

namespace iconation\IconSDK\Wallet;

use Elliptic\EC;
use Exception;
use iconation\IconSDK\Utils\Helpers;

/**
 * @property string private_key
 * @property string public_key
 * @property string public_address
 */
class Wallet
{
    private $private_key;
    private $public_key;
    private $public_address;

    /**
     * @throws Exception
     */
    function __construct($privateKey = null)
    {
        if (is_null($privateKey)) { // Generate wallet
            $this->private_key = $this->create();
        } else {
            $this->private_key = $privateKey;
        }
        $this->public_key = $this->getPublicKeyFromPrivate($this->private_key);
        $this->public_address = $this->pubKeyToAddress($this->public_key);
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $private_key = '';
        for ($i = 0; $i < 64; $i++) {
                $private_key .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $private_key;
    }

    /**
     * @param $private_key
     * @return bool
     * @throws Exception
     */
    public function getPublicKeyFromPrivate($private_key)
    {
        $ec = new EC('secp256k1');
        if (!Helpers::isPrivateKey($private_key)) {
            throw new Exception('Private key must be a 64 char hex string');
        }

        $publicKey = $ec->keyFromPrivate($private_key)->getPublic(false, 'hex');
        return substr($publicKey, 2);
    }

    public function pubKeyToAddress($publicKey)
    {
        return "hx" . substr(hash('sha3-256', hex2bin($publicKey)), -40);
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->private_key;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    /**
     * @return string
     */
    public function getPublicAddress(): string
    {
        return $this->public_address;
    }


}