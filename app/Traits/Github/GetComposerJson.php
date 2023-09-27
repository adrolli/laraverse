<?php

namespace App\Traits\Github;

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

                $this->handleApiError($response, $apiUrl);

                return null;
            }
        } catch (\Exception $e) {

            $this->handleApiError($e, $apiUrl);

            return null;
        }
    }
}
