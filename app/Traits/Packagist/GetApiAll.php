<?php

namespace App\Traits\Packagist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetApiAll
{
    public function getPackagistPackagesFromApi()
    {

        $packagistApiUrl = 'https://packagist.org/packages/list.json';

        $client = new Client();

        try {

            $response = $client->get($packagistApiUrl);
            $data = json_decode($response->getBody(), true);
            $packageNames = $data['packageNames'];

            return $packageNames;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packageNames);

        }

    }
}
