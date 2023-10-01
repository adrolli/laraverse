<?php

namespace App\Traits\Packagist;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

trait GetApiUpdates
{
    use ErrorHandler;

    public function getPackagistUpdatesFromApi($timestamp)
    {

        $packagistApiUrl = "https://packagist.org/metadata/changes.json?since=$timestamp";

        try {
            $response = Http::withHeaders([
                'User-Agent' => config('laraverse_api_identifier'),
                'Contact' => config('laraverse_api_mail'),
                'Website' => config('laraverse_api_web'),
            ])->get($packagistApiUrl);

            $packageChanges = json_decode($response->getBody(), true);

            $packagesToCreate = [];
            $packagesToDelete = [];

            foreach ($packageChanges['actions'] as $action) {
                if ($action['type'] === 'update') {
                    $packagesToCreate[] = $action['package'];
                } elseif ($action['type'] === 'delete') {
                    $packagesToDelete[] = $action['package'];
                }
            }

            return [
                'packagesToCreate' => $packagesToCreate,
                'packagesToDelete' => $packagesToDelete,
            ];

            return $packageChanges;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, 'Update at '.$timestamp);

        }
    }
}
