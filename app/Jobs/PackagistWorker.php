<?php

/*
|--------------------------------------------------------------------------
| Laraverse Packagist Worker
|--------------------------------------------------------------------------
|
| This job should run hourly to manage all updates (create, update, and
| delete) from the Packagist API and write them to PackagistPackages.
| This job starts PackagistUpdate and PackagistDelete in batch.
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\Packagist\GetApiAll;
use App\Traits\Packagist\GetApiPackage;
use App\Traits\Packagist\GetApiUpdates;
use App\Traits\Packagist\GetDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistWorker implements ShouldQueue
{
    use Dispatchable, GetApiAll, GetApiPackage, GetApiUpdates, GetDatabase,
        InteractsWithQueue, JobProgress, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    public $batch;

    public function __construct()
    {
        $this->tries = config('app.laraverse_packagist_tries');
        $this->timeout = config('app.laraverse_packagist_timeout');
        $this->maxExceptions = config('app.laraverse_packagist_exceptions');
        $this->backoff = config('app.laraverse_packagist_backoff');
        $this->batch = config('app.laraverse_packagist_batch');
    }

    public function handle(): void
    {
        activity()->log('Packagist Worker started');

        $this->setProgress(0);

        $batchSize = $this->batch;

        $packagesFromDb = $this->getPackagistPackagesFromDb();
        $packagesFromDbCount = count($packagesFromDb);

        activity()->log('Packagist Worker found '.$packagesFromDbCount.' packages in database');

        $this->setProgress(10);

        $packagesFromApi = $this->getPackagistPackagesFromApi();
        $packagesFromApiCount = count($packagesFromApi);

        activity()->log('Packagist Worker found '.$packagesFromApiCount.' packages in All API');

        $this->setProgress(20);

        $hoursAgo = 1;
        $timestamp = (int) (microtime(true) * 10000) - ($hoursAgo * 60 * 60 * 10000);
        $updatesFromApi = $this->getPackagistUpdatesFromApi($timestamp);
        $updatesFromApiCount = count($updatesFromApi['packagesToCreate']);
        $deletesFromApiCount = count($updatesFromApi['packagesToDelete']);

        activity()->log('Packagist Worker found '.$updatesFromApiCount.' updates and '.$deletesFromApiCount.' deletions in Update API');

        $this->setProgress(30);

        $packagesToCreateFromDb = array_diff($packagesFromApi, $packagesFromDb);
        $packagesToDeleteFromDb = array_diff($packagesFromDb, $packagesFromApi);

        $packagesToCreateFromApi = $updatesFromApi['packagesToCreate'];
        $packagesToDeleteFromApi = $updatesFromApi['packagesToDelete'];

        $packagesToUpdateFromApi = array_intersect($packagesFromDb, $packagesToCreateFromApi);
        $packagesToCreateFromApi = array_diff($packagesToCreateFromApi, $packagesFromDb);

        $packagesToCreate = array_unique(array_merge($packagesToCreateFromDb, $packagesToCreateFromApi));
        $packagesToUpdate = $packagesToUpdateFromApi;
        $packagesToDelete = array_unique(array_merge($packagesToDeleteFromDb, $packagesToDeleteFromApi));

        $this->removeDevBranches($packagesToCreate);
        $this->removeDevBranches($packagesToUpdate);

        $createCount = count($packagesToCreate);
        $updateCount = count($packagesToUpdate);
        $deleteCount = count($packagesToDelete);

        activity()->log('Packagist Worker will create '.$createCount.', update '.$updateCount.' and delete '.$deleteCount.' packages');

        $this->setProgress(40);

        $createChunks = array_chunk($packagesToCreate, $batchSize);

        foreach ($createChunks as $createChunk) {
            PackagistCreate::dispatch($createChunk);
        }

        $this->setProgress(60);

        $updateChunks = array_chunk($packagesToUpdate, $batchSize);

        foreach ($updateChunks as $updateChunk) {
            PackagistUpdate::dispatch($updateChunk);
        }

        $this->setProgress(80);

        $deleteChunks = array_chunk($packagesToDelete, $batchSize);

        foreach ($deleteChunks as $deleteChunk) {
            PackagistDelete::dispatch($deleteChunk);
        }

        $this->setProgress(100);

    }

    // Check if the package contains '~dev'
    public function removeDevBranches(&$array)
    {
        foreach ($array as $key => $value) {
            if (strpos($value, '~dev') !== false) {

                $newValue = str_replace('~dev', '', $value);

                if (array_search($newValue, $array) !== false) {
                    unset($array[$key]);
                } else {
                    $array[$key] = $newValue;
                }
            }
        }
    }
}
