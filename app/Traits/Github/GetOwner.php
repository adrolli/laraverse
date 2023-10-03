<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetOwner
{
    use ErrorHandler;

    public function getGitHubOwner($ownerApiUrl)
    {
        $client = new Client();

        $apiUrl = $ownerApiUrl;

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $contents = json_decode($response->getBody(), true);

                return $contents;

            } else {

                $this->handleApiError($apiUrl, $response->getBody());

                return null;

            }

        } catch (\Exception $e) {

            $this->handleApiError($apiUrl, $e);

            return null;
        }
    }
}
