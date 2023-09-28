<?php

namespace App\Traits\Github;

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

                $this->handleApiError($response, $apiUrl);

                return null;
            }
        } catch (\Exception $e) {

            $this->handleApiError($e, $apiUrl);

            return null;
        }
    }
}
