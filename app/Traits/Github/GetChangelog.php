<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetChangelog
{
    use ErrorHandler;

    public function getGitHubChangelog($apiUrl)
    {
        $client = new Client();

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/vnd.github.v3.raw',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $changelog = $response->getBody()->getContents();

                return $changelog;

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
