<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Models\PackagistPackage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PackagistController extends Controller
{
    public function updatePackage($packageDetails)
    {
        try {

            $packageName = $packageDetails['package']['name'];

            $dataToFill = [
                'data' => $packageDetails['package'],
                'title' => $packageName,
                'slug' => str_replace('/', '_', $packageName),
            ];

            PackagistPackage::updateOrCreate(
                ['slug' => $dataToFill['slug']],
                $dataToFill
            );

            activity()->log("Packagist package {$packageName} updated");

        } catch (Exception $e) {

            activity()->log("Packagist package {$packageName} update failed");

        }
    }

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

            $apiErrorMessage = 'An error occurred while fetching all packages from Packagist.';

            return $this->handleApiError($apiErrorMessage, $requestException);
        }

    }

    public function getPackagistUpdates($since)
    {

        activity()->log('Update packages from packagist since...');

    }

    public function handleApiError($apiErrorMessage, $requestException)
    {
        $response = $requestException->getResponse();

        activity()->log($apiErrorMessage);

        if ($response) {
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            return response()->json([
                'error' => $apiErrorMessage,
                'statusCode' => $statusCode,
                'responseBody' => $responseBody,
            ], $statusCode);
        } else {
            return response()->json(['error' => $apiErrorMessage]);
        }

    }
}
