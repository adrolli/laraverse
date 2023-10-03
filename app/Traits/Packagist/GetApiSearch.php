<?php

namespace App\Traits\Packagist;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

trait GetApiSearch
{
    use ErrorHandler;

    public function getPackagistSearchFromApi($search)
    {
        $packagistApiUrl = "https://packagist.org/search.json?q=$search";

        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.laraverse_api_identifier'),
                'Contact' => config('app.laraverse_api_mail'),
                'Website' => config('app.laraverse_api_web'),
            ])->get($packagistApiUrl);

            $packagesToTag = $response->json();

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
