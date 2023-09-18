<?php

namespace App\Traits\Packagist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetApiUpdates
{
    public function getPackagistUpdatesFromApi($timestamp)
    {

        $packagistApiUrl = "https://packagist.org/metadata/changes.json?since=$timestamp";

        $client = new Client();

        try {
            $response = $client->get($packagistApiUrl);
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

            return $this->handleApiError($requestException);

        }
    }
}
