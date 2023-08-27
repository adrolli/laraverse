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

class PackagistUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $packageCount = PackagistPackage::count();

        if ($packageCount > 0) {
            // There are entries in the PackagistPackages table
        } else {
            $this->processPackages();
        }

    }

    public function processPackages()
    {
        $packageNames = $this->getAllPackages();
        $batchSize = 50;

        $packagesChunks = array_chunk($packageNames, $batchSize);

        foreach ($packagesChunks as $chunk) {
            PackagistPackagesUpdate::dispatch($chunk);
        }
    }

    /*

    php artisan queue:table
    php artisan queue:failed-table
    php artisan queue:batches-table
    php artisan migrate

    */

    /* use Batchable instead of Queueable
    public function processPackages()
    {
        $packageNames = $this->getAllPackages();
        $batchSize = 50;

        $packagesChunks = array_chunk($packageNames, $batchSize);

        $batch = Bus::batch([]);

        foreach ($packagesChunks as $chunk) {
            $batch->add(new PackagistPackagesUpdate($chunk));
        }

        $batch->dispatch();
    }
    */

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
