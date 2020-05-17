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

    function __construct($privateKey = null)
    {
        if (is_null($privateKey)) { // Generate wallet
            $this->private_key = $this->create();
        } else {
            $this->private_key = $privateKey;
        }
        try {
            $this->public_key = $this->getPublicKeyFromPrivate($this->private_key);
        } catch (Exception $e) {
            throw $e;
        }
        $this->public_address = $this->pubKeyToAddress($this->public_key);
    }

    public function create()
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $private_key = '';
        for ($i = 0; $i < 64; $i++) {
            try {
                $private_key .= $characters[random_int(0, $charactersLength - 1)];
            } catch (Exception $e) {
                return $e->getMessage();
            }
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
            throw new Exception('Invalid private key');
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