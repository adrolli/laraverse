<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Models\PackagistPackage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PackagistController extends Controller
{
    public function updatePackages()
    {
        $packagistApiUrl = 'https://packagist.org/packages/list.json';
        $client = new Client();

        try {
            $response = $client->get($packagistApiUrl);
            $data = json_decode($response->getBody(), true);

            $packageNames = $data['packageNames'];

            foreach ($packageNames as $packageName) {

                // Fetch detailed package information
                $packageDetailsResponse = $client->get("https://packagist.org/packages/{$packageName}.json");
                $packageDetails = json_decode($packageDetailsResponse->getBody(), true);

                $dataToFill = [
                    'data' => $packageDetails,
                    'title' => $packageDetails['package']['name'],
                    'slug' => $packageDetails['package']['name'],
                ];

                $package = PackagistPackage::updateOrCreate(
                    ['slug' => $dataToFill['slug']],
                    $dataToFill
                );

                echo "Package: {$packageDetails['package']['name']}<br>";
            }

            return response()->json(['message' => 'Packages updated successfully']);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response) {
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();

                return response()->json([
                    'error' => 'An error occurred while fetching packages.',
                    'statusCode' => $statusCode,
                    'responseBody' => $responseBody,
                ], $statusCode);
            } else {
                return response()->json(['error' => 'An error occurred while fetching packages.']);
            }
        }
    }
}
