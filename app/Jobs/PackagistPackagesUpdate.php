<?php

namespace App\Jobs;

use App\Models\PackagistPackage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psy\Exception\Exception;

class PackagistPackagesUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $packageNames;

    public function __construct(array $packageNames)
    {
        $this->packageNames = $packageNames;
    }

    public function handle()
    {
        $packages = $this->packageNames;

        foreach ($packages as $package) {
            $packageData = $this->getPackage($package);
            $this->updatePackage($packageData);
            sleep(1);
        }
    }

    public function updatePackage($packageDetails)
    {
        try {

            $packageName = $packageDetails['package']['name'];

            $parts = explode('/', $packageName);
            $vendorPart = $parts[0];
            $packagePart = $parts[1];

            if ($vendorPart === $packagePart) {
                $packageTitle = ucwords(str_replace('-', ' ', $vendorPart));
            } else {
                $packageTitle = ucwords(str_replace('-', ' ', $vendorPart)).' '.ucwords(str_replace('-', ' ', $packagePart));
            }

            $dataToFill = [
                'data' => $packageDetails['package'],
                'title' => $packageTitle,
                'slug' => $packageName,
                'type' => $packageDetails['package']['type'],
                'repository_updated' => false,
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
