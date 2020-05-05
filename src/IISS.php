<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;

/**
 * @author Dimitris Frangiadakis
 */
class IISS
{
    private $version = "0x3";
    private $icon_service_URL;

    public function __construct($url)
    {
        $this->icon_service_URL = $url;
    }

    public function setStake($value, $from, $stepLimit, string $privateKey, $nid = '0x1')
    {
        $methodParams = array(
            "value" => Helpers::icxToHex($value)
        );

        return $this->sendTransaction('setStake', $methodParams, $from, $stepLimit, $privateKey, $nid);
    }

    public function getStake($address)
    {
        $methodParams = array(
            "address" => $address
        );

        return $this->icx_call('getStake', $methodParams);
    }

    public function setDelegation($delegations, $from, $stepLimit, string $privateKey, $nid)
    {

        return $this->sendTransaction('setStake', $delegations, $from, $stepLimit, $privateKey, $nid);
    }

    public function getDelegation($address)
    {
        $methodParams = array(
            "address" => $address
        );

        return $this->icx_call('getStake', $methodParams);
    }

    private function sendTransaction($method, $methodParams, $from, $stepLimit, string $privateKey, $nid)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "from" => $from,
                "to" => "cx0000000000000000000000000000000000000000",
                "version" => $this->version,
                "nid" => $nid,
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "dataType" => "call",
                "data" => array(
                    "method" => $method,
                    "params" => $methodParams
                )
            )
        );

        //Serialize transaction
        $params = $data['params'];
        //Sort all tables depending on keys
        ksort($params);
        ksort($params['data']);
        ksort($params['data']['params']);

        //Prepare the string
        $serialized_transaction = "icx_sendTransaction.";
        //TODO Serializer https://github.com/icon-project/icon-sdk-js/blob/3ab30c0dbc2759cb480942b8463044fd0c89a703/lib/data/Util.js#L127

        $serialized_transaction = substr($serialized_transaction, 0, -1);

        //Hash serialized transaction
        $msg_hash = hash('sha3-256', $serialized_transaction);

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

        //Add signature to transaction data
        $data["params"]["signature"] = $transaction_signature;

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    private function icx_call($method, $methodParams)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "id" => 1234,
            "method" => "icx_call",
            "params" => array(
                "to" => "cx0000000000000000000000000000000000000000",
                "dataType" => "call",
                "data" => array(
                    "method" => $method,
                    "params" => $methodParams
                )
            )
        );

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    /**
     * @param $data
     * @return bool|string
     */
    private function sendRequest($data)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        return curl_exec($ch);
    }
}
