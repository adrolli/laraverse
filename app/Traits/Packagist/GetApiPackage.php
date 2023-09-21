<?php

namespace App\Traits\Packagist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetApiPackage
{
    public function getPackage($packageName)
    {
        try {

            $client = new Client();
            $packageInfo = $client->get("https://packagist.org/packages/{$packageName}.json");
            $packageJson = json_decode($packageInfo->getBody(), true);

            // Debug activity()->log("Packagist package {$packageName} fetched");

            return $packageJson;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packageName);
        }
    }
}
