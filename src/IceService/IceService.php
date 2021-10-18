<?php

namespace iconation\IconSDK\IceService;

use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use iconation\IconSDK\Utils\Helpers;

/**
 * @author Dimitris Frangiadakis
 */
class IceService
{

    /** @string string $iconServiceUrl
     *
     */
    //Mainnet
    //private $iconServiceUrl = 'https://ctz.solidwallet.io/api/v3';
    //Yeouido
    //private $iconServiceUrl = "https://bicon.net.solidwallet.io/api/v3";

    private $version;
    private $iconServiceUrl;
    private $transactionBuilder;

    public function __construct(string $url)
    {
        $this->version = '0x3';
        $this->iconServiceUrl = $url;
        $this->transactionBuilder = new TransactionBuilder($this);
    }

    // TODO find ICE specs
}