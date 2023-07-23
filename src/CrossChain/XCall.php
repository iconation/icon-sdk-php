<?php

namespace iconation\IconSDK\CrossChain;

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Transaction\TransactionBuilder;
use iconation\IconSDK\Transaction\TransactionTypes;
use stdClass;

/**
 * @author Dimitris Frangiadakis
 */
class XCall
{
    private BtpAddress $sourceContract;
    private BtpAddress $destinationContact;
    private IconService $iconService;

    public function __construct(BtpAddress $sourceContract, BtpAddress $destinationContact, IconService $iconService)
    {
        $this->sourceContract = $sourceContract;
        $this->destinationContact = $destinationContact;
        $this->iconService = $iconService;
    }

    public function sendCallMessage(string $data, string $rollbackData = null): ?stdClass
    {
        $encodedData = '0x'.bin2hex($data);

        $params = new stdClass();
        $params->method = "sendCallMessage";
        $params->params = new stdClass();
        $params->params->_to = $this->destinationContact->getBtpAddress();
        $params->params->_data = $data;

        if (!is_null($rollbackData)) {
            $params->params->_rollback = '0x'.bin2hex($rollbackData);
        }

        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->sourceContract->getAddress())
            ->call(params: $params)
            ->send();
    }

    public function getFee(bool $rollback = false): ?stdClass
    {
        $params = new stdClass();
        $params->method = "getFee";
        $params->params = new stdClass();
        $params->params->_net = $this->destinationContact->getNetworkAddress();
        $params->params->_rollback = $rollback ? "0x1" : "0x0";
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->sourceContract->getAddress())
            ->call(params: $params)
            ->send();
    }

    public function executeRollback(string $eventId): ?stdClass
    {
        $params = new stdClass();
        $params->method = "executeRollback";
        $params->params = new stdClass();
        $params->params->_sn = $eventId;
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->sourceContract->getAddress())
            ->call(params: $params)
            ->send();
    }

    public function executeCall(string $reqId, $data): ?stdClass
    {
        $params = new stdClass();
        $params->method = "executeCall";
        $params->params = new stdClass();
        $params->params->_reqId = $reqId;
        $params->params->_data = $data;
        $transactionBuilder = new TransactionBuilder(iconService: $this->iconService);

        return $transactionBuilder
            ->method(method: TransactionTypes::CALL)
            ->to(address:$this->destinationContact->getAddress())
            ->call(params: $params)
            ->send();
    }
}