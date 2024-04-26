<?php

namespace App\Services;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class TrackTickApiService
{

    private Client $client;
    private string $accessToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('app.track_tik.base_url')
        ]);
        $this->accessToken = config('app.track_tik.access_token');
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function fetchEmployees(string|null $provider): mixed
    {
        try {
            $response = $this->client->get('employees', [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                ],
                'query' => [
                    'tags:in' => $provider,
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Failed get data from TrackTik API: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getEmployee(int $employeeId): mixed
    {
        try {
            $response = $this->client->get("employees/{$employeeId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Failed get data from TrackTik API: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function storeEmployee(array $data)
    {
        try {
            $response = $this->client->post('employees', [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Failed to send employee data to TrackTik API: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function updateEmployee(int $employeeId, array $data): mixed
    {
        try {
            $response = $this->client->put("employees/{$employeeId}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Failed to send employee data to TrackTik API: ' . $e->getMessage(), $e->getCode());
        }
    }

}
