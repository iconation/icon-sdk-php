<?php

namespace iconation\IconSDK;

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
        $methodParams = array(
            "value" => Helpers::icxToHex($value)
        );

        return $this->sendTransactionToGovernanceContract('setStake', $methodParams, $from, $stepLimit, $privateKey, $nid);
    }

    public function getStake($address)
    {
        $methodParams = array(
            "address" => $address
        );

        return $this->icx_call('getStake', $methodParams);
    }

    public function setDelegation($delegations, $from, $stepLimit, string $privateKey, $nid)
    {

        return $this->sendTransactionToGovernanceContract('setDelegation', $delegations, $from, $stepLimit, $privateKey, $nid);
    }

    public function getDelegation($address)
    {
        $methodParams = array(
            "address" => $address
        );

        return $this->icx_call('getDelegation', $methodParams);
    }

    private function sendTransactionToGovernanceContract($method, $methodParams, $from, $stepLimit, string $privateKey, $nid)
    {
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::SEND_TRANSACTION)
            ->from($from)
            ->to('cx0000000000000000000000000000000000000000')
            ->version($this->version)
            ->nid($nid)
            ->stepLimit($stepLimit)
            ->timestamp()
            ->call($method, $methodParams)
            ->sign($privateKey)
            ->get();

        return $this->sendRequest($transaction->getTransactionObject());
    }

    private function icx_call($method, $methodParams)
    {
        $transaction = new TransactionBuilder();
        $transaction = $transaction
            ->method(TransactionTypes::CALL)
            ->to('cx0000000000000000000000000000000000000000')
            ->call($method, $methodParams)
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
