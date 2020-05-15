<?php

namespace iconation\IconSDK;

use Elliptic\EC;

/**
 * @author Dimitris Frangiadakis
 */
class IconService
{

    /** @string string $iconServiceUrl
     *
     */
    //Mainnet
    //private $iconServiceUrl = 'https://ctz.solidwallet.io/api/v3';
    //Yeouido
    //private $iconServiceUrl = "https://bicon.net.solidwallet.io/api/v3";

    private $version = "0x3";
    private $iconServiceUrl;

    public function __construct($url)
    {
        $this->iconServiceUrl = $url;
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::LAST_BLOCK)
            ->send();
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::BLOCK_BY_HEIGHT)
            ->blockHeight($height)
            ->send();
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::BLOCK_BY_HASH)
            ->blockHash($hash)
            ->send();
    }

    /**
     * icx_call
     *
     * @param string $score SCORE we want to interact with eg. cxb0776ee37f5b45bfaea8cff1d8232fbb6122ec32
     * @param \stdClass $params Array of SCORE method possible parameters eg. array("address" => "hx1f9a3310f60a03934b917509c86442db703cbd52")
     *
     * @return object
     */
    //TODO migrate
    public function icx_call($score, $params)
    {

        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(\iconation\IconSDK\TransactionTypes::CALL)
            ->to($score)
            ->call($params)
            ->get();

        return $this->sendRequest($transaction->getTransactionObject());
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::BALANCE)
            ->address($address)
            ->send();
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
    //TODO migrate
    public function icx_getScoreApi($address)
    {
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::BALANCE)
            ->address($address)
            ->send();
    }

    /**
     * icx_getTotalSupply
     *
     * Get ICX Total Supply
     *
     * @return object
     */

    public function icx_getTotalSupply()
    {
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::TOTAL_SUPPLY)
            ->send();
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

    //TODO Keep migrating from here on
    public function icx_getTransactionResult($txHash)
    {
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::TRANSACTION_RESULT)
            ->txHash($txHash)
            ->send();
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::TRANSACTION_BY_HASH)
            ->txHash($txHash)
            ->send();
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
        $transaction = new TransactionBuilder();
        return $transaction
            ->method(TransactionTypes::STATUS)
            ->filter($keys)
            ->send();
    }

    public function send($from, $to, $value, $stepLimit, string $privateKey, $nid = '0x1')
    {
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(\iconation\IconSDK\TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->value($value)
            ->version($this->version)
            ->nid($nid)
            ->stepLimit($stepLimit)
            ->timestamp()
            ->nonce()
            ->sign($privateKey)
            ->get();

        //Send request to RPC
        return $this->sendRequest($transaction->getTransactionObject());
    }

    public function callSCORE($from, $to, $stepLimit, string $privateKey, string $method, \stdClass $params, $nid = '0x1')
    {
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->stepLimit($stepLimit)
            ->nid($nid)
            ->nonce()
            ->call($params)
            ->sign($privateKey)
            ->get();

        return $this->sendRequest($transaction->getTransactionObject());
    }

    public function installSCORE($from, $stepLimit, string $privateKey, string $score, \stdClass $params, $nid = '0x1')
    {
        //TODO
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
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to('cx0000000000000000000000000000000000000000')
            ->stepLimit($stepLimit)
            ->nid($nid)
            ->nonce()
            ->call($params, 'deploy')
            ->sign($privateKey)
            ->get();
        //TODO sign($privateKey)


        return $this->sendRequest($data);
    }

    public function updateSCORE($from, $to, $stepLimit, string $privateKey, string $score, array $params, $nid = '0x1')
    {
        //TODO
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
        //TODO sign($privateKey)


        return $this->sendRequest($data);
    }

    public function message($from, $to, $stepLimit, string $privateKey, string $message, string $value = "0x0", $nid = '0x1')
    {
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(\iconation\IconSDK\TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->message($message)
            ->version($this->version)
            ->nid($nid)
            ->stepLimit($stepLimit)
            ->timestamp()
            ->nonce()
            ->sign($privateKey)
            ->get();

        return $this->sendRequest($transaction->getTransactionObject());
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
     * @return object
     */
    public function sendRequest($data)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->iconServiceUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        return json_decode(curl_exec($ch));
    }

    public function setIconServiceUrl(string $url): bool
    {
        $this->iconServiceUrl = $url;
        return true;
    }
}
