<?php

namespace iconation\IconSDK\IconService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;
use iconation\IconSDK\Wallet\Wallet;
use stdClass;

/**
 * @author Dimitris Frangiadakis
 */
class IRC2
{
    private string $contract;
    private IconService $iconService;

    public function __construct(string $contract, IconService $iconService)
    {
        $this->contract = $contract;
        $this->iconService = $iconService;
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function decimals(): ?stdClass
    {
        $params = new stdClass();
        $params->method = "decimals";
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
    public function balanceOf(string $account): ?stdClass
    {
        $params = new stdClass();
        $params->method = "balanceOf";
        $params->params = new stdClass();
        $params->params->_owner = $account;
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
    public function transfer(
        string $to,
        string $value,
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
        $params->params->_value = substr($value, 0, 2) === '0x' ? $value : Helpers::icxToHex($value);
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
}
