<?php

namespace App\Traits\Packagist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetApiSearch
{
    use ErrorHandler;

    public function getPackagistSearchFromApi($search)
    {

        $packagistApiUrl = "https://packagist.org/search.json?q=$search";

        $client = new Client();

        try {
            $response = $client->get($packagistApiUrl);
            $packagesToTag = json_decode($response->getBody(), true);

            foreach ($packagesToTag as $package) {
                // Todo: tag the package or item
                echo $package.'<br>';
            }

            return $packagesToTag;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $search);

        }
    }
}
