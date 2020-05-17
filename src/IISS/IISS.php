<?php

namespace iconation\IconSDK\IISS;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;

/**
 * @author Dimitris Frangiadakis
 */
class IISS
{
    private $version = "0x3";
    private $icon_service_URL;

    public function __construct($url)
    {
        $this->icon_service_URL = $url;
    }

    public function setStake($value, $from, $stepLimit, string $privateKey, $nid = '0x1')
    {
        $methodParams = new \stdClass();
        $methodParams->value = Helpers::icxToHex($value);

        return $this->sendTransactionToGovernanceContract('setStake', $methodParams, $from, $stepLimit, $privateKey, $nid);
    }

    public function getStake($address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->icx_call('getStake', $methodParams);
    }

    public function setDelegation($delegations, $from, $stepLimit, string $privateKey, $nid)
    {
        $methodParams = new \stdClass();
        $methodParams->delegations = $delegations;

        return $this->sendTransactionToGovernanceContract('setDelegation', $methodParams, $from, $stepLimit, $privateKey, $nid);
    }

    public function getDelegation($address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->icx_call('getDelegation', $methodParams);
    }

    public function claimIScore($from, $stepLimit, string $privateKey, $nid){
        return $this->sendTransactionToGovernanceContract('claimIScsore', null, $from, $stepLimit, $privateKey, $nid);
    }

    public function queryIScore($address)
    {
        $methodParams = new \stdClass();
        $methodParams->address = $address;

        return $this->icx_call('queryIScore', $methodParams);
    }

    private function sendTransactionToGovernanceContract($method, $methodParams, $from, $stepLimit, string $privateKey, $nid)
    {
        $params = new \stdClass();
        $params->method = $method;
        if (isset($methodParams)){
            $params->params = $methodParams;
        }

        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to('cx0000000000000000000000000000000000000000')
            ->version($this->version)
            ->nid($nid)
            ->stepLimit($stepLimit)
            ->timestamp()
            ->call($params)
            ->sign($privateKey)
            ->get();

        return $this->sendRequest($transaction->getTransactionObject());
    }

    private function icx_call(string $method, \stdClass $methodParams)
    {
        $params = new \stdClass();
        $params->method = $method;
        $params->params = $methodParams;

        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::CALL)
            ->to('cx0000000000000000000000000000000000000000')
            ->call($params)
            ->get();

        $result = $this->sendRequest($transaction->getTransactionObject());

        return ($result);
    }

    /**
     * @param $data
     * @return bool|string
     */
    private function sendRequest($data)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->icon_service_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        return curl_exec($ch);
    }
}
