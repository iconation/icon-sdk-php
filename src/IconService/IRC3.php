<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;
use stdClass;

/**
 * @author Dimitris Frangiadakis
 */
class IRC3
{
    private string $contract;
    private TransactionBuilder $transactionBuilder;
    private IconService $iconService;

    public function __construct(string $contract, IconService $iconService, TransactionBuilder $transactionBuilder)
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

    public function ownerOf(string $tokenId): ?stdClass
    {
        $params = new stdClass();
        $params->method = "ownerOf";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function getApproved(string $tokenId): ?stdClass
    {
        $params = new stdClass();
        $params->method = "getApproved";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;

        return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to($this->contract)
            ->call($params)
            ->send();
    }

    public function approve(string $from, string $to, string $tokenId, string $privateKey, ?string $stepLimit = null, string $nid= '0x1', ?string $data = null): ?stdClass
    {
        $params = new stdClass();
        $params->method = "approve";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_tokenId = $tokenId;
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



    public function transfer(string $from, string $to, string $tokenId, string $privateKey, ?string $stepLimit = null, string $nid= '0x1', ?string $data = null): ?stdClass
    {
        $params = new stdClass();
        $params->method = "transfer";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_tokenId = $tokenId;
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

    public function transferFrom(string $from, string $to, string $tokenId, string $privateKey, ?string $stepLimit = null, string $nid= '0x1', ?string $data = null): ?stdClass
    {
        $params = new stdClass();
        $params->method = "transferFrom";
        $params->params = new stdClass();
        $params->params->_from = $from;
        $params->params->_to = $to;
        $params->params->_tokenId = $tokenId;
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

    // https://github.com/icon2infiniti/Samples/tree/master/IRC3
}