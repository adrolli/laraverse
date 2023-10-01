<?php

namespace App\Traits\Packagist;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

trait GetApiPackage
{
    use ErrorHandler;

    public function getPackage($packageName)
    {
        $packagistApiUrl = "https://packagist.org/packages/{$packageName}.json";

        try {

            $response = Http::withHeaders([
                'User-Agent' => config('laraverse_api_identifier'),
                'Contact' => config('laraverse_api_mail'),
                'Website' => config('laraverse_api_web'),
            ])->get($packagistApiUrl);

            $packageJson = json_decode($response->getBody(), true);

            return $packageJson;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packageName);
        }
    }
}
