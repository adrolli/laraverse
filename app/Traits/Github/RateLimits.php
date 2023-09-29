<?php

namespace App\Traits\Github;

use GuzzleHttp\Client;

trait RateLimits
{
    use ErrorHandler;

    public function monitorRateLimits()
    {
        $client = new Client();

        $apiUrl = 'https://api.github.com/rate_limit';

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $rateLimits = json_decode($response->getBody(), true);

                return $rateLimits;

            } else {

                $this->handleApiError($response, 'Rate Limits');

                return null;

            }
        } catch (\Exception $e) {

            $this->handleApiError($e, 'Rate Limits');

            return null;
        }
    }
}
