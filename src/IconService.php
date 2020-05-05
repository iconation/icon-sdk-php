<?php

namespace mitsosf\IconSDK;

use Elliptic\EC;

/**
 * @author Dimitris Frangiadakis
 */
class IconService
{

    /** @string string $icon_service_URL
     *
     */
    //Mainnet
    //private $icon_service_URL = 'https://ctz.solidwallet.io/api/v3';
    //Yeouido
    //private $icon_service_URL = "https://bicon.net.solidwallet.io/api/v3";

    private $version = "0x3";
    private $icon_service_URL;

    public function __construct($url)
    {
        $this->icon_service_URL = $url;
    }

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
        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getBlockByHeight
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

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_getBlockByHash
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

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    /**
     * icx_call
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

        $result = $this->sendRequest($data);

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

        $result = $this->sendRequest($data);

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

        $result = $this->sendRequest($data);

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

        $result = $this->sendRequest($data);

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

        $result = $this->sendRequest($data);

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
        $result = $this->sendRequest($data);

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

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    public function send($from, $to, $value, $stepLimit, string $privateKey, $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => $to,
                "value" => $value,
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
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

        //Send request to RPC
        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    public function callSCORE($from, $to, $stepLimit, string $privateKey, string $method, array $params, $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => $to,
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "dataType" => "call",
                "data" => array(
                    "method" => $method,
                    "params" => $params
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
        foreach ($params as $key => $value) {
            if (!is_array($value)) {
                $serialized_transaction .= $key . "." . $value . ".";
            } else {
                $serialized_transaction .= $key . ".{";
                foreach ($value as $data_key => $data_value) {
                    if (!is_array($data_value)) {
                        $serialized_transaction .= $data_key . "." . $data_value . ".";
                    } else {
                        $serialized_transaction .= $data_key . ".{";
                        foreach ($data_value as $param_key => $param_value) {
                            $serialized_transaction .= $param_key . "." . $param_value . ".";
                        }
                        $serialized_transaction = substr($serialized_transaction, 0, -1);
                        $serialized_transaction .= "}";
                    }
                }
                $serialized_transaction .= "}.";
            }
        }
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

    public function installSCORE($from, $stepLimit, string $privateKey, string $score, array $params, $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => "cx0000000000000000000000000000000000000000", // address 0 means SCORE install
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "dataType" => "deploy",
                "data" => array(
                    "content" => $score, // compressed SCORE data
                    "contentType" => "application/zip",
                    "params" => $params // parameters to be passed to on_install()
                )

            )
        );

        //Serialize transaction
        $params = $data['params'];
        //Sort all tables depending on keys
        ksort($params);
        ksort($params)['data'];
        ksort($params['data']['params']);

        //Prepare the string
        $serialized_transaction = "icx_sendTransaction.";
        foreach ($params as $key => $value) {
            if (!is_array($value)) {
                $serialized_transaction .= $key . "." . $value . ".";
            } else {
                $serialized_transaction .= $key . ".{";
                foreach ($value as $data_key => $data_value) {
                    if (!is_array($data_value)) {
                        $serialized_transaction .= $data_key . "." . $data_value . ".";
                    } else {
                        $serialized_transaction .= $data_key . ".{";
                        foreach ($data_value as $param_key => $param_value) {
                            $serialized_transaction .= $param_key . "." . $param_value . ".";
                        }
                        $serialized_transaction = substr($serialized_transaction, 0, -1);
                        $serialized_transaction .= "}";
                    }
                }
                $serialized_transaction .= "}.";
            }
        }
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

        //Send request to RPC
        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    public function updateSCORE($from, $to, $stepLimit, string $privateKey, string $score, array $params, $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => $to, // SCORE address to be updated
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "dataType" => "deploy",
                "data" => array(
                    "content" => $score, // compressed SCORE data
                    "contentType" => "application/zip",
                    "params" => $params // parameters to be passed to on_update()
                )

            )
        );

        //Serialize transaction
        $params = $data['params'];
        //Sort all tables depending on keys
        ksort($params);
        ksort($params)['data'];
        ksort($params['data']['params']);

        //Prepare the string
        $serialized_transaction = "icx_sendTransaction.";
        foreach ($params as $key => $value) {
            if (!is_array($value)) {
                $serialized_transaction .= $key . "." . $value . ".";
            } else {
                $serialized_transaction .= $key . ".{";
                foreach ($value as $data_key => $data_value) {
                    if (!is_array($data_value)) {
                        $serialized_transaction .= $data_key . "." . $data_value . ".";
                    } else {
                        $serialized_transaction .= $data_key . ".{";
                        foreach ($data_value as $param_key => $param_value) {
                            $serialized_transaction .= $param_key . "." . $param_value . ".";
                        }
                        $serialized_transaction = substr($serialized_transaction, 0, -1);
                        $serialized_transaction .= "}";
                    }
                }
                $serialized_transaction .= "}.";
            }
        }
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

        //Send request to RPC
        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }

    public function message($from, $to, $stepLimit, string $privateKey, string $message, string $value = "0x0", $nid = '0x1')
    {
        //Create transaction table
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => $to, // SCORE address to be updated
                "value" => $value,
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "dataType" => "message",
                "data" => "0x" . bin2hex($message)
            )
        );

        //Serialize transaction
        $params = $data['params'];
        //Sort all tables depending on keys
        ksort($params);


        //Prepare the string
        $serialized_transaction = "icx_sendTransaction.";
        foreach ($params as $key => $value) {
            $serialized_transaction .= $key . "." . $value . ".";
        }
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

    //Not working for now
    /*
    /**
     * debug_estimateStep
     *
     * Estimate step amount for a transaction
     *
     * @param string $from The address that created the transaction
     * @param string $to The address to receive coins, or SCORE address to execute the transaction.
     * @param string $value Amount of ICX coins in loop to transfer (1 icx = 1 ^ 18 loop) in hex eg. 0xde0b6b3a7640000
     * @param string $timestamp Transaction creation time. timestamp is in microsecond in hex. eg. 0x563a6cf330136
     * @param string $nid Network ID ("0x1" for Mainnet, "0x2" for Testnet, etc)
     * @param string $nonce An arbitrary number used to prevent transaction hash collision eg.0x1
     * @return string
     */

    //TODO make it work for contracts as well
    /*public function debug_estimateStep($from, $to, $timestamp, $value = "0", $nid = "0x1", $nonce = "0x1")
    {
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "debug_estimateStep",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => $to,
                "value" => $value,
                "timestamp" => $timestamp,
                "nid" => $nid,
                "nonce" => $nonce
            )
        );

        $result = $this->sendRequest($data);

        //Return as object
        return json_decode($result);
    }*/



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
