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
     * @return object
     */
    public function sendRequest($data)
    {
        //Send request to RPC
        $data_string = json_encode($data);
        $ch = curl_init($this->iconService->getIconServiceUrl());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        return json_decode(curl_exec($ch));
    }
}