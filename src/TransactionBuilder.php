<?php

namespace iconation\IconSDK;

use Elliptic\EC;

class TransactionBuilder
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function method(string $method): TransactionBuilder
    {
        $this->transaction->setMethod($method);
        return $this;
    }

    public function version(string $version): TransactionBuilder
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

    public function nonce(): TransactionBuilder
    {
        $params = [
            'nonce' => '0x' . dechex(rand(1, 1000))
        ];
        $this->transaction->setParams($params);
        return $this;
    }

    public function sign(string $privateKey): TransactionBuilder
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

    /**
     * @return \stdClass
     */
    public function getTransactionObject(): \stdClass
    {
        $transaction = new \stdClass();
        $transaction->jsonrpc = $this->transaction->getJsonrpc();
        $transaction->id = $this->transaction->getId();

        if (!empty($this->transaction->getMethod())) {
            $transaction->method = $this->transaction->getMethod();
        }
        if (!empty($this->transaction->getParams())) {
            $transaction->params = $this->transaction->getParams();
        }

        return $transaction;
    }

    //TODO add endpoint url in here
    public function send(): \stdClass
    {
        return $this->transaction->getIconService()->sendRequest($this->getTransactionObject());
    }
}