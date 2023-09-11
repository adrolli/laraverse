<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetPackagistAll
{
    public function getAllPackages()
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
