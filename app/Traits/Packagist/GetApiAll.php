<?php

namespace App\Traits\Packagist;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

trait GetApiAll
{
    use ErrorHandler;

    public function getPackagistPackagesFromApi()
    {

        $packagistApiUrl = 'https://packagist.org/packages/list.json';

        try {

            $response = Http::withHeaders([
                'User-Agent' => config('app.laraverse_api_identifier'),
                'Contact' => config('app.laraverse_api_mail'),
                'Website' => config('app.laraverse_api_web'),
            ])->get($packagistApiUrl);

            $data = json_decode($response->getBody(), true);
            $packageNames = $data['packageNames'];

            return $packageNames;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packageNames);

        }

    }
}
