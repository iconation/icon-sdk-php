<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;
use mitsosf\IconSDK\Helpers;
use mitsosf\IconSDK\IconService;
use mitsosf\IconSDK\Serializer;

class Transaction{
    private $transaction;
    private $iconService;
    public function __construct()
    {
        $this->transaction = new \stdClass();
        $this->transaction->jsonrpc = '2.0';
        $this->transaction->id = 1234;

        $this->iconService = new IconService('https://ctz.solidwallet.io/api/v3');
    }

    public function method(string $method) :Transaction
    {
        $this->transaction->method = $method;
        return $this;
    }

    public function version(string $version) :Transaction
    {
        $this->transaction->params->version = $version;
        return $this;
    }

    public function from(string $address) :Transaction
    {
        $this->transaction->params->from = $address;
        return $this;
    }

    public function to(string $address) :Transaction
    {
        $this->transaction->params->to = $address;
        return $this;
    }

    public function timestamp() :Transaction
    {
        $this->transaction->params->timestamp = Helpers::getBase64TimestampInMilliseconds();
        return $this;
    }

    public function nid(string $nid = '0x1') :Transaction
    {
        $this->transaction->params->nid = $nid;
        return $this;
    }

    public function nonce() :Transaction
    {
        $this->transaction->params->nonce = '0x'.dechex(rand(1,1000));
        return $this;
    }

    public function sign(string $privateKey) :Transaction
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
        $this->transaction->params->signature = $transaction_signature;
        return $this;
    }

    public function testnet(string $url) :Transaction
    {
        $this->iconService->setIconServiceUrl($url);
        return $this;
    }

    public function send() :\stdClass
    {
        return $this->iconService->sendRequest($this->transaction);
    }
}