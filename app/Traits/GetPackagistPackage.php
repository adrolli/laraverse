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

            $apiErrorMessage = "An error occurred while fetching the package {$packageName}.";

            return $this->handleApiError($apiErrorMessage, $requestException);
        }
    }
}
