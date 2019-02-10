<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;
use GMP;
use http\Exception;
use kornrunner\Keccak;
use Mdanter\Ecc\EccFactory;
use function Sodium\add;

class Wallet
{
    private $private_key;
    private $public_key;

    function __construct($privateKey = null, $publicKey = null)
    {
        if (is_null($privateKey) && is_null($publicKey)) {
            return "Both a private and a public key cannot be supplied to the constructor.";
        }

        if (!is_null($privateKey) && !is_null($publicKey)) {
            return "Both a private and a public key cannot be supplied to the constructor.";
        }

        if (is_null($privateKey )){

        }

    }

    public function create(){


        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $private_key = '';
        for ($i = 0; $i < 64; $i++) {
            try {
                $private_key .= $characters[random_int(0, $charactersLength - 1)];
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return $private_key;
    }

    /**
     * @param $private_key
     * @return bool
     * @throws \Exception
     */
    public function getPublicKey($private_key){
        $ec = new EC('secp256k1');
        if (!$this->isPrivateKey($private_key)){
            throw new \Exception('Invalid private key');
        }

        $publicKey = $ec->keyFromPrivate($private_key)->getPublic(false, 'hex');
        return substr($publicKey,2);
    }

    public function pubKeyToAddress($publicKey) {
        return "hx" . substr(hash('sha3-256', hex2bin($publicKey)),-40);
    }


    public function isPrivateKey($key)
    {
        $length = 64;
        if (strlen($key)!== $length){
            return false;
        }

        if (!ctype_xdigit($key)){
            return false;
        }

        return true;
    }

    public function isPublicKey($key){
        $length = 128;
        if (strlen($key)!== $length){
            return false;
        }

        if (!ctype_xdigit($key)){
            return false;
        }

        return true;
     }
}