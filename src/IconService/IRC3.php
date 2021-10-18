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
    private $contract;
    private $transactionBuilder;
    private $iconService;

    public function __construct(string $contract, IconService $iconService)
    {
        $this->contract = $contract;
        $this->iconService = $iconService;
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
    }

    //TODO

    // https://github.com/icon2infiniti/Samples/tree/master/IRC3
}