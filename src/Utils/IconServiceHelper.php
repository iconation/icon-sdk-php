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
    public function sendRequest($data, ?bool $wait = false)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->iconService->getIconServiceUrl());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Content-Type: application/json',
        ];
        if ($wait) {
            $headers[] = 'timeout: 10000';
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0 || !str_contains(strtolower($result), 'jsonrpc')) {
            curl_close($ch);
            throw new \Exception('Error: '. curl_error($ch));
        }

        curl_close($ch);
        return json_decode($result);

    }
}