<?php

namespace App\Traits\GitHub;

use GuzzleHttp\Client;

trait GetPackageJson
{
    use ErrorHandler;

    public function getGitHubPackageJson($apiUrl)
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

                $packageJson = $response->getBody()->getContents();

                return $packageJson;

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
