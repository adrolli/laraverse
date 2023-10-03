<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;
use GuzzleHttp\Client;

trait GetSearchPage
{
    use ErrorHandler;

    public function getGitHubSearchPage($keyPhrase, $perPage, $page)
    {
        $client = new Client();

        $apiUrl = "https://api.github.com/search/repositories?q={$keyPhrase}&per_page={$perPage}&page={$page}";

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

                $this->handleApiError($keyPhrase, $response);

                return null;

            }
        } catch (\Exception $e) {

            $this->handleApiError($keyPhrase, $e);

            return null;
        }
    }
}
