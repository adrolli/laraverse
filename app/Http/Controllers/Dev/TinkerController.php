<?php

/*
|--------------------------------------------------------------------------
| Laraverse Tinker Controller
|--------------------------------------------------------------------------
|
| Test things here ...
|
*/

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Jobs\PackagistCreate;
use App\Jobs\PackagistDelete;
use App\Jobs\PackagistUpdate;
use App\Traits\Packagist\GetApiAll;
use App\Traits\Packagist\GetApiUpdates;
use App\Traits\Packagist\GetDatabase;
use Illuminate\Queue\SerializesModels;

class TinkerController extends Controller
{
    use GetApiAll, GetApiUpdates, GetDatabase, SerializesModels;

    public $batch;

    public function __invoke()
    {
        $this->batch = config('app.laraverse_batch');
        $this->tinkerNow();
    }

    public function tinkerNow()
    {
        $secretToken = config('app.laraverse_token');

        if (request('token') !== $secretToken) {
            activity()->log('Unauthorized tinker request');

            abort(403, 'Unauthorized');
        }

        activity()->log('Packagist Worker started');

        $batchSize = $this->batch;

        $packagesFromDb = $this->getPackagistPackagesFromDb();
        $packagesFromDbCount = count($packagesFromDb);

        activity()->log('Packagist Worker found '.$packagesFromDbCount.' packages in database');

        $packagesFromApi = $this->getPackagistPackagesFromApi();
        $packagesFromApiCount = count($packagesFromApi);

        activity()->log('Packagist Worker found '.$packagesFromApiCount.' packages in All API');

        $hoursAgo = 1;
        $timestamp = (int) (microtime(true) * 10000) - ($hoursAgo * 60 * 60 * 10000);
        $updatesFromApi = $this->getPackagistUpdatesFromApi($timestamp);
        $updatesFromApiCount = count($updatesFromApi['packagesToCreate']);
        $deletesFromApiCount = count($updatesFromApi['packagesToDelete']);

        activity()->log('Packagist Worker found '.$updatesFromApiCount.' updates and '.$deletesFromApiCount.' deletions in Update API');

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

        $createChunks = array_chunk($packagesToCreate, $batchSize);

        foreach ($createChunks as $createChunk) {
            PackagistCreate::dispatch($createChunk);
        }

        $updateChunks = array_chunk($packagesToUpdate, $batchSize);

        foreach ($updateChunks as $updateChunk) {
            PackagistUpdate::dispatch($updateChunk);
        }

        $deleteChunks = array_chunk($packagesToDelete, $batchSize);

        foreach ($deleteChunks as $deleteChunk) {
            PackagistDelete::dispatch($deleteChunk);
        }
    }

    // Check if the value contains '~dev'
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
