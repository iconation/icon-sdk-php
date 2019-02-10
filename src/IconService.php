<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;
use Elliptic\Utils;

/**
 *  A sample class
 *
 *  Use this section to define what this class is doing, the PHPDocumentator will use this
 *  to automatically generate an API documentation using this information.
 *
 * @author Dimitris Frangiadakis
 */
class IconService
{

    /** @string string $icon_service_URL
     *
     */
    //Mainnet
    //private $icon_service_URL = 'https://ctz.solidwallet.io/api/v3';
    private $icon_service_URL = "https://bicon.net.solidwallet.io/api/v3";

    /**
     * icx_getLastBlock
     *
     * Get the latest block
     *
     * @return object
     */
    public function icx_getLastBlock()
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getLastBlock",
            "id" => 1234
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getLastBlock
     *
     * Get the latest block
     *
     * @param string $height Block height in hex e.g 0x3
     *
     * @return object
     */

    public function icx_getBlockByHeight($height)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getBlockByHeight",
            "id" => 1234,
            "params" => array(
                "height" => $height
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getLastBlock
     *
     * Get the latest block
     *
     * @param string $hash Block hash e.g 0x1fcf7c34dc875681761bdaa5d75d770e78e8166b5c4f06c226c53300cbe85f57
     *
     * @return object
     */

    public function icx_getBlockByHash($hash)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getBlockByHash",
            "id" => 1234,
            "params" => array(
                "hash" => $hash
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getLastBlock
     *
     * Get the latest block
     *
     * @param string $from Message sender eg. hxbe258ceb872e08851f1f59694dac2558708ece11
     * @param string $score SCORE we want to interact with eg. cxb0776ee37f5b45bfaea8cff1d8232fbb6122ec32
     * @param string $method SCORE method to be invoked eg. "get_balance"
     * @param array $params Array of SCORE method possible parameters eg. array("address" => "hx1f9a3310f60a03934b917509c86442db703cbd52")
     *
     * @return object
     */

    public function icx_call($from, $score, $method, $params)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_call",
            "id" => 1234,
            "params" => array(
                "from" => $from,
                "to" => $score,
                "dataType" => "call",
                "data" => array(
                    "method" => $method,
                    "params" => $params
                )
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getBalance
     *
     * Get the balance of an address
     *
     * @param string $address The address to be checked
     *
     * @return object
     */

    public function icx_getBalance($address)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getBalance",
            "id" => 1234,
            "params" => array(
                "address" => $address
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getScoreApi
     *
     * Get a SCORE API
     *
     * @param string $address SCORE address
     *
     * @return object
     */

    public function icx_getScoreApi($address)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getScoreApi",
            "id" => 1234,
            "params" => array(
                "address" => $address
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getScoreApi
     *
     * Get ICX Total Supply
     *
     * @return object
     */

    public function icx_getTotalSupply()
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getTotalSupply",
            "id" => 1234
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getTransactionResult
     *
     * Get transaction result
     *
     * @param string $txHash Transaction hash
     *
     * @return object
     */

    public function icx_getTransactionResult($txHash)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getTransactionResult",
            "id" => 1234,
            "params" => array(
                "txHash" => $txHash
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getTransactionByHash
     *
     * Get transaction result
     *
     * @param string $txHash Transaction hash
     *
     * @return object
     */

    public function icx_getTransactionByHash($txHash)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_getTransactionByHash",
            "id" => 1234,
            "params" => array(
                "txHash" => $txHash
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    /**
     * ise_getStatus
     *
     * Get IconService status
     *
     * @param array $keys Array of keys to filter eg. ["lastBlock"]
     *
     * @return object
     */

    public function ise_getStatus($keys)
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "ise_getStatus",
            "id" => 1234,
            "params" => array(
                "filter" => $keys
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }

    public function icx_sendTransaction($from, $to, $value, $stepLimit, string $privateKey, $version = "0x3", $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $version,
                "from" => $from,
                "to" => $to,
                "value" => $value,
                "stepLimit" => $stepLimit,
                "timestamp" => $this->getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1"
            )
        );
        
        //Serialize transaction
        $params = $data['params'];
        //Sort table depending on keys
        ksort($params);
        //Prepare the string
        $serialized_transaction = "icx_sendTransaction";
        foreach ($params as $key => $value) {
            $serialized_transaction .= "." . $key . "." . $value;
        }
        //return $serialized_transaction;
        $msg_hash = hash('sha3-256', $serialized_transaction);

        $ec = new EC('secp256k1');

        $private_key_object = $ec->keyFromPrivate($privateKey);

        //Create Signature

        $signing = $private_key_object->sign($msg_hash, false, "recoveryParam");

        //Break down into components and then assemble
        $sign = array(
            "r" => $signing->r->toString("hex"),
            "s" => $signing->s->toString("hex")

        );
        $rec_id = $signing->recoveryParam;

        $signature = $sign["r"] . $sign["s"] . '0'.$rec_id;

        $transaction_signature = base64_encode(hex2bin($signature));

        //Add signature to transaction data
        $data["params"]["signature"] = $transaction_signature;

        //Send request to RPC
        $data_string = json_encode($data);
        //return json_decode($data_string);
        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }


    //Not working for now
    /**
     * debug_estimateStep
     *
     * Estimate step amount for a transaction
     *
     * @param string $version Protocol version eg. ("0x3" for V3)
     * @param string $from The address that created the transaction
     * @param string $to The address to receive coins, or SCORE address to execute the transaction.
     * @param string $value Amount of ICX coins in loop to transfer (1 icx = 1 ^ 18 loop) in hex eg. 0xde0b6b3a7640000
     * @param string $timestamp Transaction creation time. timestamp is in microsecond in hex. eg. 0x563a6cf330136
     * @param string $nid Network ID ("0x1" for Mainnet, "0x2" for Testnet, etc)
     * @param string $nonce An arbitrary number used to prevent transaction hash collision eg.0x1
     * @return string
     */
    /*
    //TODO make it work for contracts as well
    public function debug_estimateStep($version, $from, $to, $timestamp, $value = "0", $nid = "0x1", $nonce = "0x1")
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "debug_estimateStep",
            "id" => 1234,
            "params" => array(
                "version" => $version,
                "from" => $from,
                "to" => $to,
                "value" => $value,
                "timestamp" => $timestamp,
                "nid" => $nid,
                "nonce" => $nonce
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        //Return as object
        return json_decode($result);
    }*/

    private function getBase64TimestampInMilliseconds()
    {
        $milliseconds = round(microtime(true) * 1000000);
        $milliseconds = '0x' . dechex($milliseconds);

        return $milliseconds;
    }

}
