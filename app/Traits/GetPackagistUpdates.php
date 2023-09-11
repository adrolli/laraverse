<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait GetPackagistUpdates
{
    public function fetchPackageChanges($timestamp)
    {

        $packagistApiUrl = "https://packagist.org/metadata/changes.json?since=$timestamp";

        $client = new Client();

        try {
            $response = $client->get($packagistApiUrl);
            $packageChanges = json_decode($response->getBody(), true);

            $packagesToAdd = [];
            $packagesToRemove = [];

            foreach ($packageChanges['actions'] as $action) {
                if ($action['type'] === 'update') {
                    $packagesToAdd[] = $action['package'];
                } elseif ($action['type'] === 'delete') {
                    $packagesToRemove[] = $action['package'];
                }
            }

            return [
                'packagesToAdd' => $packagesToAdd,
                'packagesToRemove' => $packagesToRemove,
            ];

            return $packageChanges;

        } catch (RequestException $requestException) {

            return $this->handleApiError($requestException, $packagesToAdd);

        }

    }
}
