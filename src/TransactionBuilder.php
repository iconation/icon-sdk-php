<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;
use mitsosf\IconSDK\Helpers;
use mitsosf\IconSDK\IconService;
use mitsosf\IconSDK\Serializer;

class TransactionBuilder
{
    private $transaction;
    private $iconService;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function method(string $method): Transaction
    {
        $this->transaction->setMethod($method);
        return $this->transaction;
    }

    public function version(string $version): Transaction
    {
        $params = [
            'version' => $version
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function address(string $address): Transaction
    {
        $params = [
            'address' => $address
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function from(string $address): Transaction
    {
        $params = [
            'from' => $address
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function to(string $address): Transaction
    {
        $params = [
            'to' => $address
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function timestamp(): Transaction
    {
        $params = [
            'timestamp' => Helpers::getBase64TimestampInMilliseconds()
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function nid(string $nid = '0x1'): Transaction
    {
        $params = [
            'nid' => $nid
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function nonce(): Transaction
    {
        $params = [
            'nonce' => '0x' . dechex(rand(1, 1000))
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function sign(string $privateKey): Transaction
    {
        $serializedTransaction = Serializer::serialize($this->transaction);
        $msg_hash = hash('sha3-256', $serializedTransaction);
        //Initialize secp256k1 elliptic curve
        $ec = new EC('secp256k1');

        //Initialize private key object
        $private_key_object = $ec->keyFromPrivate($privateKey);

        //Sign transaction
        $signing = $private_key_object->sign($msg_hash, false, "recoveryParam");
        //Break down into components and then assemble
        $sign = array(
            "r" => $signing->r->toString("hex"),
            "s" => $signing->s->toString("hex")

        );
        //Get recovery bit
        $rec_id = $signing->recoveryParam;
        //Convert signature to hex string
        $signature = $sign["r"] . $sign["s"] . '0' . $rec_id;
        //Encode hex signature to base64
        $transaction_signature = base64_encode(hex2bin($signature));

        $params = [
            'signature' => $transaction_signature
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    //Possibly remove from here
    public function testnet(string $url): Transaction
    {
        $this->transaction->setIconService($url);
        return $this->transaction;
    }

    public function blockHeight(string $height): Transaction
    {
        if (substr($height, 0, 2) === '0x') {
            $height = '0x' . hexdec($height);
        }

        $params = [
            'height' => $height
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    public function blockHash(string $hash): Transaction
    {
        $params = [
            'hash' => $hash
        ];
        $this->transaction->setParams($params);
        return $this->transaction;
    }

    //TODO add endpoint url in here
    public function send(): \stdClass
    {
        return $this->transaction->getIconService()->sendRequest($this->transaction);
    }
}