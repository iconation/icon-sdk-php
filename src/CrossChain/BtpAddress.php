<?php

namespace iconation\IconSDK\CrossChain;

use iconation\IconSDK\Utils\Helpers;

/**
 * @author Dimitris Frangiadakis
 */
class BtpAddress
{
    private string $nid;
    private string $network;
    private string $address;
    public function __construct(string $nid, string $network, string $address)
    {
        $this->nid = $nid;
        $this->network = $network;
        $this->address = $address;
    }

    public function getNid(): string
    {
        return $this->nid;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getNetworkAddress(): string
    {
        return $this->nid . '.' . $this->network;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getBtpAddress(): string
    {
        return 'btp://'.$this->nid . '.' . $this->network . '/' . $this->address;
    }

    public static function isBtpAddress(string $btpAddress): bool
    {
        $btpAddress = explode('btp://', $btpAddress);
        if (count($btpAddress) !== 2) {
            return false;
        }

        $btpAddress = explode('/', $btpAddress[1]);
        if (count($btpAddress) !== 2) {
            return false;
        }

        $networkIdentifier = $btpAddress[0];
        $contract = $btpAddress[1];

        $networkIdentifierComponents = explode('.', $btpAddress[0]);
        if (count($networkIdentifierComponents) !== 2) {
            return false;
        }

        if (!Helpers::isContractAddress($contract)) {
            return false;
        }

        return true;
    }


}