<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetPackagistPackage
{
    public function getPackage($packageName)
    {
        try {

            $client = new Client();
            $packageInfo = $client->get("https://packagist.org/packages/{$packageName}.json");
            $packageJson = json_decode($packageInfo->getBody(), true);

            return $packageJson;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packageName);
        }
    }
}
