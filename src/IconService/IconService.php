<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;

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

    private $version;
    private $iconServiceUrl;
    private $transactionBuilder;

    public function __construct($url)
    {
        $this->version = '0x3';
        $this->iconServiceUrl = $url;
        $this->transactionBuilder = new TransactionBuilder($this);
    }

    /**
     * getLastBlock
     *
     * Get the latest block
     *
     * @return object
     */
    public function getLastBlock()
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::LAST_BLOCK)
            ->send();
    }

    /**
     * getBlockByHeight
     *
     * Get the latest block
     *
     * @param string $height Block height in hex e.g 0x3
     *
     * @return object
     */

    public function getBlockByHeight($height)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::BLOCK_BY_HEIGHT)
            ->blockHeight($height)
            ->send();
    }

    /**
     * getBlockByHash
     *
     * Get the latest block
     *
     * @param string $hash Block hash e.g 0x1fcf7c34dc875681761bdaa5d75d770e78e8166b5c4f06c226c53300cbe85f57
     *
     * @return object
     */

    public function getBlockByHash($hash)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::BLOCK_BY_HASH)
            ->blockHash($hash)
            ->send();
    }

    /**
     * call
     *
     * @param string $score SCORE we want to interact with eg. cxb0776ee37f5b45bfaea8cff1d8232fbb6122ec32
     * @param \stdClass $params Array of SCORE method possible parameters eg. array("address" => "hx1f9a3310f60a03934b917509c86442db703cbd52")
     *
     * @return object
     */
    //TODO migrate
    public function call($score, $params)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($score)
            ->call($params)
            ->send();
    }

    /**
     * getBalance
     *
     * Get the balance of an address
     *
     * @param string $address The address to be checked
     *
     * @return object
     */

    public function getBalance($address)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::BALANCE)
            ->address($address)
            ->send();
    }

    /**
     * getScoreApi
     *
     * Get a SCORE API
     *
     * @param string $address SCORE address
     *
     * @return object
     */
    //TODO migrate
    public function getScoreApi($address)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::BALANCE)
            ->address($address)
            ->send();
    }

    /**
     * getTotalSupply
     *
     * Get ICX Total Supply
     *
     * @return object
     */

    public function getTotalSupply()
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::TOTAL_SUPPLY)
            ->send();
    }

    /**
     * getTransactionResult
     *
     * Get transaction result
     *
     * @param string $txHash Transaction hash
     *
     * @return object
     */

    //TODO Keep migrating from here on
    public function getTransactionResult($txHash)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::TRANSACTION_RESULT)
            ->txHash($txHash)
            ->send();
    }

    /**
     * getTransactionByHash
     *
     * Get transaction result
     *
     * @param string $txHash Transaction hash
     *
     * @return object
     */

    public function getTransactionByHash($txHash)
    {
        return $this->transactionBuilder
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

    public function getStatus($keys)
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::STATUS)
            ->filter($keys)
            ->send();
    }

    public function send(string $from, string $to, string $value, string $privateKey, ?string $stepLimit = null, $nid = '0x1')
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->value($value)
            ->version($this->version)
            ->nid($nid)
            ->timestamp()
            ->nonce()
            ->stepLimit($stepLimit)
            ->sign($privateKey)
            ->send();
    }

    /* public function callSCORE($from, $to, $stepLimit, string $privateKey, string $method, \stdClass $params, $nid = '0x1')
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
             "method" => "sendTransaction",
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
             "method" => "sendTransaction",
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



         return $this->sendRequest($data);
     }*/

    public function message(string $from, string $to, string $privateKey, string $message, ?string $stepLimit = null, string $nid = '0x1')
    {
        return $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($to)
            ->message($message)
            ->version($this->version)
            ->nid($nid)
            ->timestamp()
            ->nonce()
            ->stepLimit($stepLimit)
            ->sign($privateKey)
            ->send();
    }

    //Not working for now

    /**
     * debug_estimateStep
     *
     * Estimate step amount for a transaction
     *
     * @param string $from The address that created the transaction
     * @param string $to The address to receive coins, or SCORE address to execute the transaction.
     * @param string $value Amount of ICX coins in loop to transfer (1 icx = 1 ^ 18 loop) in hex eg. 0xde0b6b3a7640000
     * @param string $nid Network ID ("0x1" for Mainnet, "0x2" for Testnet, etc)
     * @return string
     */

    //TODO make it work for contracts as well
    public function debug_estimateStep(string $from, string $to, string $value = "0", string $nid = "0x1")
    {
        $url = $this->iconServiceUrl;
        $this->setIconServiceUrl(substr($url, 0,-2).'debug/v3');

        $res = $this->transactionBuilder
            ->method(TransactionTypes::ESTIMATE_STEP)
            ->version($this->version)
            ->from($from)
            ->to($to)
            ->value($value)
            ->timestamp()
            ->nid($nid)
            ->nonce()
            ->send();

        $this->setIconServiceUrl($url);

        return $res;
    }

    public function setIconServiceUrl(string $url): bool
    {
        $this->iconServiceUrl = $url;
        return true;
    }

    public function getIconServiceUrl(): string
    {
        return $this->iconServiceUrl;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
