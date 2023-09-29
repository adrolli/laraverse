<?php

namespace App\Traits\Github;

use GuzzleHttp\Client;

trait GetSearch
{
    use ErrorHandler;

    public function getGitHubSearch($keyphrase, $perPage)
    {
        $client = new Client();

        $page = 1;

        $apiUrl = "https://api.github.com/search/repositories?q={$keyphrase}&per_page={$perPage}&page={$page}";

        // Todo:
        // - Iterate over pages
        // - Place and run the job

        try {
            $response = $client->get($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer '.config('app.github_api_token'),
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {

                $searchResult = json_decode($response->getBody(), true);

                return $searchResult;

            } else {

                $this->handleApiError($response, $keyphrase);

                return null;

            }
        } catch (\Exception $e) {

            $this->handleApiError($e, $keyphrase);

            return null;
        }
    }
}
