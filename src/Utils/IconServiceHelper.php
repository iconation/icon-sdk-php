<?php

namespace iconation\IconSDK\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use iconation\IconSDK\IconService\IconService;

class IconServiceHelper
{
    private IconService $iconService;

    public function __construct(IconService $iconService)
    {
        $this->iconService = $iconService;
    }

    /**
     * @param $data
     * @return object|null
     * @throws \Exception
     */
    public function sendRequest($data, ?bool $wait = false): ?object
    {
        $client = new Client();

        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data
        ];

        if ($wait) {
            $options['timeout'] = 10000;
        }

        try {
            $response = $client->request('POST', $this->iconService->getIconServiceUrl(), $options);
            $body = $response->getBody();
            $result = json_decode($body->getContents());

            if (!isset($result->jsonrpc)) {
                throw new \Exception('Response does not contain jsonrpc');
            }


        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody();
            $result = json_decode($responseBody->getContents());
        } catch (\Exception $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }

        return $result;
    }
}