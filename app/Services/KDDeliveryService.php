<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class KDDeliveryService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // Correct Base URL (without redundant paths)
        $this->baseUrl = "https://api.sandbox.staging.kd-solutions.in/";
        $this->apiKey = "ST_5cd7a44681892bdbcdbe";

        // Initialize Guzzle Client
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10.0, // Timeout in seconds
        ]);
    }

    /**
     * Create a Contact using KD Delivery API
     *
     * @param string $name
     * @param string $phoneNumber
     * @param string $addrLine1
     * @param string|null $addrLine2
     * @return array
     * @throws \Exception
     */
    public function createContact($name, $phoneNumber, $addrLine1, $addrLine2 = null)
    {
        try {
            $response = $this->client->post('api/v2/tp/contacts', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey'       => $this->apiKey,
                ],
                'json' => [
                    'name'         => $name,
                    'phone_number' => $phoneNumber,
                    'addr_line_1'  => $addrLine1,
                    'addr_line_2'  => $addrLine2,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Error creating contact: " . $errorResponse);
        }
    }

    /**
     * Create an Order using KD Delivery API
     *
     * @param array $orderData
     * @return array
     * @throws \Exception
     */
    public function createOrder(array $orderData)
    {
        try {
            $response = $this->client->post('api/v2/tp/orders', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey'       => $this->apiKey,
                ],
                'json' => $orderData,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Error creating order: " . $errorResponse);
        }
    }
}
