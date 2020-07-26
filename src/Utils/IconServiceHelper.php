<?php

namespace iconation\IconSDK\Utils;

use iconation\IconSDK\IconService\IconService;

class IconServiceHelper
{
    private $iconService;

    public function __construct(IconService $iconService)
    {
        $this->iconService = $iconService;
    }

    /**
     * @param $data
     * @return object|null
     * @throws \Exception
     */
    public function sendRequest($data)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->iconService->getIconServiceUrl());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0 || strpos(strtolower($result), 'jsonrpc') === false) {
            curl_close($ch);
            throw new \Exception('Curl error' . curl_error($ch) !== '' ? curl_error($ch) : $result );
        }

        curl_close($ch);
        return json_decode($result);

    }
}