<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;
use stdClass;

/**
 * @author Dimitris Frangiadakis
 */
class IRC2
{
    private $contract;
    private $transactionBuilder;
    private $iconService;

    public function __construct(string $contract, IconService $iconService)
    {
        $this->contract = $contract;
        $this->iconService = $iconService;
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
    }

    public function name()
    {
        $params = new stdClass();
        $params->method = "name";

        $res = $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();

        return isset($res->result) ? $res->result : $res;
    }

    public function symbol()
    {
        $params = new stdClass();
        $params->method = "symbol";

        $res = $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();

        return isset($res->result) ? $res->result : $res;
    }

    public function decimals()
    {
        $params = new stdClass();
        $params->method = "decimals";

        $res = $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();

        return isset($res->result) ? $res->result : $res;
    }

    public function totalSupply()
    {
        $params = new stdClass();
        $params->method = "totalSupply";

        $res = $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();

        return isset($res->result) ? $res->result : $res;
    }

    public function balanceOf(string $account)
    {
        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = $account;

        $res = $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();


        return isset($res->result) ? $res->result : $res;
    }

    public function transfer(string $from, string $to, string $value, string $privateKey, string $stepLimit, ?string $nid= '0x1', ?string $data = null)
    {
        $params = new stdClass();
        $params->method = "transfer";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_value = substr($value, 0, 2) === '0x' ? $value : Helpers::icxToHex($value);
        if (isset($data)) {
            $params->params->_data = $data;
        }

        $res = $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($this->contract)
            ->version($this->iconService->getVersion())
            ->nid($nid)
            ->stepLimit($stepLimit)
            ->timestamp()
            ->nonce()
            ->call($params)
            ->sign($privateKey)
            ->send();


        return isset($res->result) ? $res->result : $res;
    }
}
