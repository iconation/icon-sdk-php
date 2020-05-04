<?php

namespace mitsosf\IconSDK;

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



    private function sendTransaction($method, $methodParams, $from, $stepLimit, string $privateKey, $nid = '0x1'){
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "from" => $from,
                "to" => "cx0000000000000000000000000000000000000000",
                "value" => "0x0",
                "stepLimit" => $stepLimit,
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "data" => array(
                    "method" => $method,
                    "params" => $methodParams
                )
            )
        );
    }

    private function icx_call($method, $methodParams, $nid = '0x1'){
        $data = array(
            "jsonrpc" => "2.0",
            "method" => "icx_sendTransaction",
            "id" => 1234,
            "params" => array(
                "version" => $this->version,
                "to" => "cx0000000000000000000000000000000000000000",
                "value" => "0x0",
                "timestamp" => Helpers::getBase64TimestampInMilliseconds(),
                "nid" => $nid,
                "nonce" => "0x1",
                "dataType" => "call",
                "data" => array(
                    "method" => $method,
                    "params" => $methodParams
                )
            )
        );
    }
}
