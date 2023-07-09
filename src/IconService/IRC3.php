<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Wallet\Wallet;
use stdClass;

/**
 * @author Dimitris Frangiadakis
 */
class IRC3
{
    private string $contract;
    private IconService $iconService;

    public function __construct(string $contract, IconService $iconService)
    {
        $this->contract = $contract;
        $this->iconService = $iconService;
    }
    public function name(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "name";
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    public function symbol(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "symbol";
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    public function balanceOf(string $owner): ?stdClass
    {
        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = $owner;
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    public function ownerOf(string $tokenId): ?stdClass
    {
        $params = new stdClass();
        $params->method = "ownerOf";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    public function getApproved(string $tokenId): ?stdClass
    {
        $params = new stdClass();
        $params->method = "getApproved";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function approve(
        string $to,
        string $tokenId,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid= '0x1',
        ?string $data = null
    ): ?stdClass
    {
        $params = new stdClass();
        $params->method = "approve";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_tokenId = $tokenId;
        if (isset($data)) {
            $params->params->_data = "0x" . bin2hex($data);
        }
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $wallet->getPublicAddress())
            ->to(address:$this->contract)
            ->version(version: $this->iconService->getVersion())
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }


    /**
     * @throws \Exception
     */
    public function transfer(
        string $to,
        string $tokenId,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid= '0x1',
        ?string $data = null
    ): ?stdClass
    {
        $params = new stdClass();
        $params->method = "transfer";
        $params->params = new stdClass();
        $params->params->_to = $to;
        $params->params->_tokenId = $tokenId;
        if (isset($data)) {
            $params->params->_data = "0x" . bin2hex($data);
        }
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $wallet->getPublicAddress())
            ->to(address:$this->contract)
            ->version(version: $this->iconService->getVersion())
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function transferFrom(
        string $from,
        string $to,
        string $tokenId,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid= '0x1',
        ?string $data = null
    ): ?stdClass
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
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $wallet->getPublicAddress())
            ->to(address:$this->contract)
            ->version(version: $this->iconService->getVersion())
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }

    public function totalSupply(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "totalSupply";

        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }


    /**
     * @throws \Exception
     */
    public function tokenByIndex(int $index): ?stdClass
    {
        $params = new stdClass();
        $params->method = "tokenByIndex";
        $params->params = new stdClass();
        $params->params->_index = strval($index);

        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function tokenOfOwnerByIndex(string $owner, int $index): ?stdClass
    {
        $params = new stdClass();
        $params->method = "tokenOfOwnerByIndex";
        $params->params = new stdClass();
        $params->params->_owner = $owner;
        $params->params->_index = strval($index);
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->contract)
            ->call(params: $params)
            ->send();
    }


    /**
     * @throws \Exception
     */
    public function mint(
        string $from,
        string $tokenId,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid= '0x1',
        ?string $data = null
    ): ?stdClass
    {
        $params = new stdClass();
        $params->method = "mint";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;
        if (isset($data)) {
            $params->params->_data = "0x" . bin2hex($data);
        }
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address:$this->contract)
            ->version(version: $this->iconService->getVersion())
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }

    /**
     * @throws \Exception
     */
    public function burn(
        string $from,
        string $tokenId,
        Wallet $wallet,
        ?string $stepLimit = null,
        string $nid= '0x1',
        ?string $data = null
    ): ?stdClass
    {
        $params = new stdClass();
        $params->method = "burn";
        $params->params = new stdClass();
        $params->params->_tokenId = $tokenId;
        if (isset($data)) {
            $params->params->_data = "0x" . bin2hex($data);
        }
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address:$this->contract)
            ->version(version: $this->iconService->getVersion())
            ->nid(nid: $nid)
            ->timestamp()
            ->nonce()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }
}