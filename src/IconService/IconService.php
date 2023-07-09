<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;
use iconation\IconSDK\Wallet\Wallet;

/**
 * @author Dimitris Frangiadakis
 */
class IconService
{
    //Mainnet - https://ctz.solidwallet.io/api/v3

    //Lisbon - https://lisbon.net.solidwallet.io/api/v3

    private string $version;
    private string $iconServiceUrl;

    public function __construct($url)
    {
        $this->version = '0x3';
        $this->iconServiceUrl = $url;
    }

    /**
     * getLastBlock
     *
     * Get the latest block
     *
     * @return object
     * @throws \Exception
     */
    public function getLastBlock(): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::LAST_BLOCK)
            ->send();
    }

    /**
     * getBlockByHeight
     *
     * Get the latest block
     *
     * @param string $height Block height in hex e.g 0x2
     *
     * @return object
     * @throws \Exception
     */

    public function getBlockByHeight(string $height): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::BLOCK_BY_HEIGHT)
            ->blockHeight(height: $height)
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
     * @throws \Exception
     */

    public function getBlockByHash(string $hash): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::BLOCK_BY_HASH)
            ->blockHash(hash: $hash)
            ->send();
    }

    /**
     * call
     *
     * @param string $score SCORE we want to interact with eg. cxb0776ee37f5b45bfaea8cff1d8232fbb6122ec32
     * @param \stdClass $params Array of SCORE method possible parameters eg. array("address" => "hx1f9a3310f60a03934b917509c86442db703cbd52")
     *
     * @return object
     * @throws \Exception
     */
    public function call(string $score, \stdClass $params): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address: $score)
            ->call(params: $params)
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
     * @throws \Exception
     */

    public function getBalance(string $address): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::BALANCE)
            ->address(address: $address)
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
     * @throws \Exception
     */
    public function getScoreApi(string $address): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::SCORE_API)
            ->address(address: $address)
            ->send();
    }

    /**
     * getTotalSupply
     *
     * Get ICX Total Supply
     *
     * @return object
     * @throws \Exception
     */

    public function getTotalSupply(): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::TOTAL_SUPPLY)
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
     * @throws \Exception
     */

    public function getTransactionResult(string $txHash): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        $result = $transactionBuilder
            ->method(method: TransactionTypes::TRANSACTION_RESULT)
            ->txHash(hash: $txHash)
            ->send();

        //If successful, return transaction fee as well
        if (!isset($result->error)) {
            $fee = $this->calculateTransactionFee(
                stepUsed: $result->result->stepUsed,
                stepPrice: $result->result->stepPrice
            );
            $result->result->transactionFee = $fee;
        }

        return $result;
    }

    private function calculateTransactionFee(string $stepUsed, string $stepPrice): string
    {
        $stepUsed = strval(hexdec($stepUsed));
        $stepPrice = Helpers::hexToIcx($stepPrice);

        return bcmul($stepUsed, $stepPrice, 18);
    }

    /**
     * getTransactionByHash
     *
     * Get transaction result
     *
     * @param string $txHash Transaction hash
     *
     * @return object
     * @throws \Exception
     */

    public function getTransactionByHash(string $txHash): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::TRANSACTION_BY_HASH)
            ->txHash(hash: $txHash)
            ->send();
    }

    /**
     * sendTransaction
     *
     * Get IconService status
     *
     * @param string $from
     * @param string $to
     * @param string $value
     * @param Wallet $wallet
     * @param string|null $stepLimit
     * @param string $nid
     * @return object
     * @throws \Exception
     */

    public function send(
        string $from,
        string $to,
        string $value,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid = '0x1'): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address:$to)
            ->value(value: $value)
            ->version(version: $this->version)
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function sendAndWait(
        string $from,
        string $to,
        string $value,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid = '0x1'
    ): object
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address:$to)
            ->value(value: $value)
            ->version(version: $this->version)
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->wait()
            ->send(true);
    }

    /* public function callSCORE($from, $to, $stepLimit, string $privateKey, string $method, \stdClass $params, $nid = '0x1')
     {
         $transaction = new TransactionBuilder();
         $transaction = $transaction
             ->method(method: TransactionTypes::SEND_TRANSACTION)
             ->from($from)
             ->to(address:$to)
             ->stepLimit($stepLimit)
             ->nid($nid)
             ->nonce()
             ->call(params: $params)
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
             ->method(method: TransactionTypes::SEND_TRANSACTION)
             ->from($from)
             ->to(address:'cx0000000000000000000000000000000000000000')
             ->stepLimit($stepLimit)
             ->nid($nid)
             ->nonce()
             ->call(params: $params, 'deploy')
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

    /**
     * @throws \Exception
     */
    public function message(
        string $from,
        string $to,
        Wallet $wallet,
        string $message,
        ?string $stepLimit = null,
        string $nid = '0x1'
    ): ?\stdClass
    {
        $transactionBuilder = new TransactionBuilder(iconService: $this);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address:$to)
            ->message(message: $message)
            ->version(version: $this->version)
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }


    /**
     * debug_estimateStep
     *
     * Estimate step amount for a transaction
     *
     * @param string $from The address that created the transaction
     * @param string $to The address to receive coins, or SCORE address to execute the transaction.
     * @param string $value Amount of ICX coins in loop to transfer (1 icx = 1 ^ 18 loop) in hex eg. 0xde0b6b3a7640000
     * @param string $nid Network ID ("0x1" for Mainnet, "0x2" for Testnet, etc)
     * @return \stdClass
     * @throws \Exception
     */

    //TODO make it work for contracts as well
    public function debug_estimateStep(
        string $from,
        string $to,
        string $value = "0",
        string $nid = "0x1"
    ): \stdClass
    {
        $url = $this->iconServiceUrl;
        $this->setIconServiceUrl($url . 'd');

        $transactionBuilder = new TransactionBuilder(iconService: $this);

        $res = $transactionBuilder
            ->method(method: TransactionTypes::ESTIMATE_STEP)
            ->version(version: $this->version)
            ->from(address: $from)
            ->to(address:$to)
            ->value($value)
            ->timestamp()
            ->nid(nid: $nid)
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
