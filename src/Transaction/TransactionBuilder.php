<?php

namespace iconation\IconSDK\Transaction;

use Elliptic\EC;
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Utils\Helpers;
use iconation\IconSDK\Utils\IconServiceHelper;
use iconation\IconSDK\Utils\Serializer;

class TransactionBuilder
{
    private $transaction;
    private $iconService;
    private $iconServiceHelper;

    public function __construct($iconService)
    {
        $this->transaction = new Transaction();
        $this->iconService = $iconService;
        $this->iconServiceHelper = new IconServiceHelper($iconService);
    }

    public function method(string $method): TransactionBuilder
    {
        $this->transaction->setMethod($method);
        return $this;
    }

    public function version(string $version = '0x3'): TransactionBuilder
    {
        $params = [
            'version' => $version
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function address(string $address): TransactionBuilder
    {
        $params = [
            'address' => $address
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function from(string $address): TransactionBuilder
    {
        $params = [
            'from' => $address
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function to(string $address): TransactionBuilder
    {
        $params = [
            'to' => $address
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function call(\stdClass $params, string $dataType = 'call'): TransactionBuilder
    {
        $params = [
            'dataType' => $dataType,
            'data' => $params
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function txHash(string $hash): TransactionBuilder
    {
        $params = [
            'txHash' => $hash
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function filter(array $filter): TransactionBuilder
    {
        $params = [
            'filter' => $filter
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function timestamp(): TransactionBuilder
    {
        $params = [
            'timestamp' => Helpers::getBase64TimestampInMilliseconds()
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function nid(string $nid = '0x1'): TransactionBuilder
    {
        $params = [
            'nid' => $nid
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function nonce($nonce = null): TransactionBuilder
    {
        $params = [
            'nonce' => isset($nonce) ? $nonce : '0x' . dechex(rand(1, 1000))
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function stepLimit(string $stepLimit = '0x186a0'): TransactionBuilder
    {
        if (substr($stepLimit, 0, 2) !== '0x') {
            $stepLimit = '0x'.dechex($stepLimit);
        }

        $params = [
            'stepLimit' => $stepLimit
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function sign(string $privateKey): TransactionBuilder
    {
        $serializedTransaction = Serializer::serialize($this->transaction, true);
        //Initialize secp256k1 elliptic curve
        $ec = new EC('secp256k1');

        //Initialize private key object
        $private_key_object = $ec->keyFromPrivate($privateKey);

        //Sign transaction
        $signing = $private_key_object->sign($serializedTransaction, false, "recoveryParam");
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
        return $this;
    }

    //Possibly remove from here
    public function testnet(string $url): TransactionBuilder
    {
        $this->transaction->setIconService($url);
        return $this;
    }

    public function blockHeight(string $height): TransactionBuilder
    {
        if (substr($height, 0, 2) === '0x') {
            $height = '0x' . hexdec($height);
        }

        $params = [
            'height' => $height
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function blockHash(string $hash): TransactionBuilder
    {
        $params = [
            'hash' => $hash
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function value(string $value): TransactionBuilder
    {
        if (substr($value, 0, 2) !== '0x') {
            $value = Helpers::icxToHex($value);
        }

        $params = [
            'value' => $value
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function message(string $message): TransactionBuilder
    {
        $params = [
            "dataType" => "message",
            "data" => "0x" . bin2hex($message)
        ];

        $this->transaction->setParams($params);
        return $this;
    }

    public function get(): Transaction
    {
        return $this->transaction;
    }

    //TODO add endpoint url in here
    public function send(): \stdClass
    {
        return $this->iconServiceHelper->sendRequest($this->transaction->getTransactionObject());
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}