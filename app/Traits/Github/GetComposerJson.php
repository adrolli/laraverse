<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetComposerJson
{
    use ErrorHandler;

    public function getGitHubComposerJson($apiUrl)
    {
        $client = new Client();

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'), // Updated config
                    'Accept' => 'application/vnd.github.v3.raw',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $composerJson = $response->getBody()->getContents();

                return $composerJson;

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
