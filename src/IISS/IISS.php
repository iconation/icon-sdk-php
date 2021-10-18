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
    private $version = "0x3";
    private $iconService;
    private $transactionBuilder;

    public function __construct(IconService $iconService)
    {
        $this->iconService = $iconService;
        $this->transactionBuilder = new TransactionBuilder($iconService);
    }

    public function setStake(string $value, string $from, string $privateKey, ?string $stepLimit = null, $nid = '0x1')
    {
        $methodParams = new \stdClass();
        $methodParams->value = Helpers::icxToHex($value);

        return $this->sendTransactionToGovernanceContract('setStake', $methodParams, $from, $privateKey, $stepLimit, $nid);
    }

    public function getStake(string $address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('getStake', $methodParams);
    }

    public function setDelegation(array $delegations, string $from, string $privateKey, ?string $stepLimit = null, $nid = '0x1')
    {
        $methodParams = new \stdClass();
        $methodParams->delegations = $delegations;

        return $this->sendTransactionToGovernanceContract('setDelegation', $methodParams, $from, $privateKey, $stepLimit, $nid);
    }

    public function getDelegation(string $address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('getDelegation', $methodParams);
    }

    public function claimIScore(string $from, string $privateKey, ?string $stepLimit = null, string $nid = '0x1'){
        return $this->sendTransactionToGovernanceContract('claimIScore', null, $from, $privateKey, $stepLimit, $nid);
    }

    public function queryIScore($address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->call('queryIScore', $methodParams);
    }

    private function sendTransactionToGovernanceContract(
        string     $method,
        ?\stdClass $methodParams,
        string     $from,
        string     $privateKey,
        ?string    $stepLimit = null,
        string     $nid = '0x1'): ?\stdClass
    {
        $params = new \stdClass();
        $params->method = $method;
        if (isset($methodParams)){
            $params->params = $methodParams;
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
}
