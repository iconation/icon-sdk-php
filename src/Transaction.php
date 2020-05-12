<?php

namespace mitsosf\IconSDK;

class Transaction
{
    private $jsonrpc;
    private $id;
    private $iconService;
    private $method;
    private $params;

    public function __construct(int $id = 1234)
    {
        $this->jsonrpc = '2.0';
        $this->id = $id;
        $this->params = new \stdClass();

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
     * @return string
     */
    public function getMethod()
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
     * @return \stdClass
     */
    public function getParams(): \stdClass
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        foreach ($params as $key => $value){
            $this->params->$key = $value;
        }
    }
}