<?php

namespace iconation\IconSDK\IISS;

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;
use iconation\IconSDK\Wallet\Wallet;

/**
 * @author Dimitris Frangiadakis
 */
class IISS
{
    private string $version = "0x3";

    private IconService $iconservice;

    public function __construct(IconService $iconService)
    {
        $this->iconservice = $iconService;
    }

    public function setStake(
        string $value,
        string $from,
        Wallet $wallet,
        $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->value = Helpers::icxToHex($value);

        return $this->sendTransactionToGovernanceContract(
            method: 'setStake',
            methodParams: $methodParams,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }

    public function getStake(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call(method: 'getStake', methodParams: $methodParams);
    }

    public function setDelegation(
        array $delegations,
        string $from,
        Wallet $wallet,
        $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->delegations = $delegations;

        return $this->sendTransactionToGovernanceContract(
            method: 'setDelegation',
            methodParams: $methodParams,
            from: $from,
            wallet:  $wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }

    public function getDelegation(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call(method: 'getDelegation', methodParams: $methodParams);
    }

    public function claimIScore(
        string $from,
        Wallet $wallet,
        string $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        return $this->sendTransactionToGovernanceContract(
            method: 'claimIScore',
            methodParams: null,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }

    public function queryIScore($address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call(method: 'queryIScore', methodParams: $methodParams);
    }

    private function sendTransactionToGovernanceContract(
        string $method,
        ?\stdClass$methodParams,
        string $from,
        Wallet $wallet,
        ?string $stepLimit= null,
        string $nid = '0x1',
        string $value = null
    ): ?\stdClass
    {
        $params = new \stdClass();
        $params->method = $method;
        if (isset($methodParams)){
            $params->params = $methodParams;
        }

        if (isset($value)){
            $params->value = $value;
        }

        $transactionBuilder = new TransactionBuilder($this->iconservice);

        return $transactionBuilder
            ->method(method: TransactionTypes::SEND_TRANSACTION)
            ->from(address: $from)
            ->to(address: 'cx0000000000000000000000000000000000000000')
            ->version(version: $this->version)
            ->nid(nid: $nid)
            ->timestamp()
            ->call(params: $params)
            ->stepLimit(stepLimit: $stepLimit)
            ->sign(wallet: $wallet)
            ->send();
    }

    private function call(string $method, ?\stdClass $methodParams): ?\stdClass
    {
        $params = new \stdClass();
        $params->method = $method;
        $params->params = $methodParams;

        $transactionBuilder = new TransactionBuilder($this->iconservice);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address: 'cx0000000000000000000000000000000000000000')
            ->call(params: $params)
            ->send();
    }

    public function setBond(
        array $bonds,
        string $from,
        Wallet $wallet,
        $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->bonds = $bonds;

        return $this->sendTransactionToGovernanceContract(
            method: 'setBond',
            methodParams: $methodParams,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid,
        );
    }

    public function getBond(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call(method: 'getBond', methodParams: $methodParams);
    }

    public function getBonderList(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call(method: 'getBonderList', methodParams: $methodParams);
    }

    public function setBonderList(
        array $bonders,
        string $from,
        Wallet $wallet,
        $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->bonderList = $bonders;

        return $this->sendTransactionToGovernanceContract(
            method: 'setBonderList',
            methodParams: $methodParams,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }

    public function registerPrep(
        string $name,
        string $email,
        string $country,
        string $city,
        string $website,
        string $details,
        string $p2pEndpoint,
        string $from,
        Wallet $wallet,
        string $nodeAddress = null,
        $nid = '0x1',
        ?string $stepLimit = null
    ): \stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->name = $name;
        $methodParams->email = $email;
        $methodParams->country = $country;
        $methodParams->city = $city;
        $methodParams->website = $website;
        $methodParams->details = $details;
        $methodParams->p2pEndpoint = $p2pEndpoint;
        if (isset($nodeAddress)) {
            $methodParams->nodeAddress = $nodeAddress;
        }

        return $this->sendTransactionToGovernanceContract(
            method:'registerPRep',
            methodParams: $methodParams,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid,
            value: '0x6c6b935b8bbd400000'
        );
    }

    public function unRegisterPrep(
        string $from,
        Wallet $wallet,
        $nid = '0x1',
        ?string $stepLimit = null
    ): ?\stdClass
    {
        return $this->sendTransactionToGovernanceContract(
            method:'unregisterPRep',
            methodParams: null,
            from: $from,
            wallet: $wallet,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }
}
