<?php

namespace App\Traits\Github;

use GuzzleHttp\Client;

trait GetRepository
{
    use ErrorHandler;

    public function getGitHubRepository($slug)
    {
        $client = new Client();

        $apiUrl = "https://api.github.com/repos/{$slug}";

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $repositoryData = json_decode($response->getBody(), true);

                return $repositoryData;

            } else {

                $this->handleApiError($response, $slug);

                return null;

            }
        } catch (\Exception $e) {

            $this->handleApiError($e, $slug);

            return null;
        }
    }
}
