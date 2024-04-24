<?php

namespace App\Services;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class TrackTickApiService
{

    private Client $client;
    private string $refreshToken;
    private string $accessToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('app.track_tik.base_url'), // TrackTik API base URL
        ]);
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getAccessToken()
    {
        try {
            $response = $this->client->post('oauth2/access_token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->refreshToken,
                    'client_id' => '',
                    'client_secret' => '',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $this->accessToken = $data['access_token'];

            return $this->accessToken;
        } catch (RequestException $e) {
            throw new Exception('Failed to get access token: ' . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function fetchEmployees(string|null $provider)
    {
        try {
            $response = $this->client->get('employees', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('TRACK_TIK_ACCESS_TOKEN'),
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

    public function getEmployee(int $employeeId)
    {
        try {
            $response = $this->client->get("employees/{$employeeId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('TRACK_TIK_ACCESS_TOKEN'),
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
                    'Authorization' => 'Bearer ' . env('TRACK_TIK_ACCESS_TOKEN'),
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
    public function updateEmployee(int $employeeId, array $data)
    {
        try {
            $response = $this->client->put("employees/{$employeeId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('TRACK_TIK_ACCESS_TOKEN'),
                ],
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Failed to send employee data to TrackTik API: ' . $e->getMessage(), $e->getCode());
        }
    }

}
