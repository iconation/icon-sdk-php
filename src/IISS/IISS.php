<?php

namespace iconation\IconSDK\IISS;

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;

/**
 * @author Dimitris Frangiadakis
 */
class IISS
{
    private string $version = "0x3";
    private TransactionBuilder $transactionBuilder;

    public function __construct(IconService $iconService)
    {
        $this->transactionBuilder = new TransactionBuilder($iconService);
    }

    public function setStake(string $value, string $from, string $privateKey, $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->value = Helpers::icxToHex($value);

        return $this->sendTransactionToGovernanceContract('setStake', $methodParams, $from, $privateKey, $stepLimit, $nid);
    }

    public function getStake(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('getStake', $methodParams);
    }

    public function setDelegation(array $delegations, string $from, string $privateKey, $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->delegations = $delegations;

        return $this->sendTransactionToGovernanceContract('setDelegation', $methodParams, $from, $privateKey, $stepLimit, $nid);
    }

    public function getDelegation(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('getDelegation', $methodParams);
    }

    public function claimIScore(string $from, string $privateKey, string $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        return $this->sendTransactionToGovernanceContract('claimIScore', null, $from, $privateKey, $stepLimit, $nid);
    }

    public function queryIScore($address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('queryIScore', $methodParams);
    }

    private function sendTransactionToGovernanceContract(string $method, ?\stdClass$methodParams, string $from, string $privateKey, ?string $stepLimit= null, string $nid = '0x1', string $value = null): ?\stdClass
    {
        $params = new \stdClass();
        $params->method = $method;
        if (isset($methodParams)){
            $params->params = $methodParams;
        }

        if (isset($value)){
            $params->value = $value;
        }

        return $this->transactionBuilder
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to('cx0000000000000000000000000000000000000000')
            ->version($this->version)
            ->nid($nid)
            ->timestamp()
            ->call($params)
            ->stepLimit($stepLimit)
            ->sign($privateKey)
            ->send();
    }

    private function call(string $method, ?\stdClass $methodParams): ?\stdClass
    {
        $params = new \stdClass();
        $params->method = $method;
        $params->params = $methodParams;

       return $this->transactionBuilder
            ->method(TransactionTypes::CALL)
            ->to('cx0000000000000000000000000000000000000000')
            ->call($params)
            ->send();
    }

    public function setBond(array $bonds, string $from, string $privateKey, $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->bonds = $bonds;

        return $this->sendTransactionToGovernanceContract('setBond', $methodParams, $from, $privateKey, $stepLimit, $nid);
    }

    public function getBond(string $address): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('getBond', $methodParams);
    }

    public function getBonderList(): ?\stdClass
    {
        return $this->call('getBonderList', null);
    }

    public function setBonderList(array $bonders, string $from, string $privateKey, $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        $methodParams = new \stdClass();
        $methodParams->bonderList = $bonders;

        return $this->sendTransactionToGovernanceContract('setBonderList', $methodParams, $from, $privateKey, $stepLimit, $nid);
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
        string $privateKey,
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
            privateKey: $privateKey,
            stepLimit: $stepLimit,
            nid: $nid,
            value: '0x6c6b935b8bbd400000'
        );
    }

    public function unRegisterPrep(string $from, string $privateKey, $nid = '0x1', ?string $stepLimit = null): ?\stdClass
    {
        return $this->sendTransactionToGovernanceContract(
            method:'unregisterPRep',
            methodParams: null,
            from: $from,
            privateKey: $privateKey,
            stepLimit: $stepLimit,
            nid: $nid
        );
    }
}
