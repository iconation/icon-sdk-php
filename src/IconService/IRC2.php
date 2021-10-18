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

    public function name(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "name";

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function symbol(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "symbol";

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function decimals(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "decimals";

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function totalSupply(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "totalSupply";

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function balanceOf(string $account): ?stdClass
    {
        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = $account;

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function transfer(string $from, string $to, string $value, string $privateKey, ?string $stepLimit = null, string $nid= '0x1', ?string $data = null): ?stdClass
    {
        $params = new stdClass();
        $params->method = "transfer";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_value = substr($value, 0, 2) === '0x' ? $value : Helpers::icxToHex($value);
        if (isset($data)) {
            $params->params->_data = "0x" . bin2hex($data);
        }

        return $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to($this->contract)
            ->version($this->iconService->getVersion())
            ->nid($nid)
            ->timestamp()
            ->nonce()
            ->call($params)
            ->stepLimit($stepLimit)
            ->sign($privateKey)
            ->send();
    }
}
