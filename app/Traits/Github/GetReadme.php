<?php

namespace App\Traits\GitHub;

use GuzzleHttp\Client;

trait GetReadme
{
    use ErrorHandler;

    public function getGitHubReadme($apiUrl)
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

                $readmeContent = $response->getBody()->getContents();

                return $readmeContent;

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
