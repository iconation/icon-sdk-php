<?php

namespace iconation\IconSDK;

class Transaction
{
    private $jsonrpc;
    private $id;
    private $iconService;
    private $method;
    private $value;
    private $params;

    public function __construct(int $id = 1234)
    {
        $this->jsonrpc = '2.0';
        $this->id = $id;
        $this->iconService = new IconService('https://ctz.solidwallet.io/api/v3');
    }

    /**
     * @return IconService
     */
    public function getIconService(): IconService
    {
        return $this->iconService;
    }

    /**
     * @param string $url
     */
    public function setIconService(string $url): void
    {
        $this->iconService = new IconService($url);
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
    public function setMethod($method): void
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
     * @param array $params
     */
    public function setParams(array $params): void
    {
        if (empty($this->params)) {
            $this->params = new \stdClass();
        }

        foreach ($params as $key => $value) {
            $this->params->$key = $value;
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
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
        if (!empty($this->getParams())) {
            $transaction->params = $this->getParams();
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

}