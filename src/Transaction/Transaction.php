<?php

namespace iconation\IconSDK\Transaction;

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Utils\IconServiceHelper;

class Transaction
{
    private string $jsonrpc;
    private int $id;
    private IconService $iconService;
    private string $method;
    private array|\stdClass $params;
    private IconServiceHelper $iconServiceHelper;

    public function __construct(IconService $iconService, string $jsonrpc = null, int $id = null)
    {
        $this->jsonrpc = is_null($jsonrpc) ? '2.0' : $jsonrpc;
        $this->iconService = $iconService;
        $this->id = is_null($id) ? rand(1, 10000) : $id;
        $this->iconServiceHelper = new IconServiceHelper($iconService);
    }

    /**
     * @return IconService
     */
    public function getIconService(): IconService
    {
        return $this->iconService;
    }

    /**
     * @return string | null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return \stdClass | null
     */
    public function getParams(): ?\stdClass
    {
        return $this->params;
    }

    /**
     * @param array|\stdClass $params
     */
    public function setParams(array|\stdClass $params): void
    {
        if ($params instanceof \stdClass) {
            $this->params = $params;
        } else {
            if (empty($this->params)) {
                $this->params = new \stdClass();
            }

            foreach ($params as $key => $value) {
                $this->params->$key = $value;
            }
        }
    }


    /**
     * @return string
     */
    public function getJsonrpc(): string
    {
        return $this->jsonrpc;
    }

    /**
     * @param string $jsonrpc
     */
    public function setJsonrpc(string $jsonrpc): void
    {
        $this->jsonrpc = $jsonrpc;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \stdClass
     */
    public function getTransactionObject(): \stdClass
    {
        $transaction = new \stdClass();
        $transaction->jsonrpc = $this->getJsonrpc();
        $transaction->id = $this->getId();

        if (!empty($this->getMethod())) {
            $transaction->method = $this->getMethod();
        }
        if (!empty($this->params)) {
            $transaction->params = $this->params;
        }

        return $transaction;
    }

    /**
     * @return \stdClass | null
     */
    public function getTransactionParamsObject(): ?\stdClass
    {
        $params = new \stdClass();
        if (isset($this->params)) {
            foreach ($this->params as $key => $value) {
                $params->{$key} = $value;
            }
        } else {
            return null;
        }

        return $params;
    }


    /**
     * @return array | null
     */
    public function getTransactionParamsArray(): ?array
    {

        $params = array();
        if (isset($this->params)) {
            foreach ($this->params as $key => $value) {
                $params[$key] = $value;
            }
        } else {
            return null;
        }

        return $params;
    }

    /**
     * @throws \Exception
     */
    public function send(?bool $wait = false): ?\stdClass
    {
        return $this->iconServiceHelper->sendRequest($this->getTransactionObject(), $wait);
    }

}