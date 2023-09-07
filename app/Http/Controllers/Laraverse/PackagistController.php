<?php

namespace App\Http\Controllers\Laraverse;

use App\Http\Controllers\Controller;
use App\Jobs\PackagistPackagesUpdate;
use App\Models\PackagistPackage;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistAll;
use App\Traits\GetPackagistDiff;
use App\Traits\GetPackagistUpdates;
use Illuminate\Queue\SerializesModels;

class PackagistController extends Controller
{
    use ErrorHandler, GetPackagistAll, GetPackagistDiff, GetPackagistUpdates, SerializesModels;

    public function __invoke()
    {
        $this->updateAllPackages();
    }

    public function updateAllPackages()
    {

        $packageCount = PackagistPackage::count();

        if ($packageCount > 0) {

            $packagesDiffDb = $this->compareWithDatabase();
            $packagesToAddDb = $packagesDiffDb['packagesToAdd'];
            $packagesToRemoveDb = $packagesDiffDb['packagesToRemove'];

            $timestamp = 16938521430000;
            $minutesAgo = 600;
            $timestamp = (int) (microtime(true) * 10000) - ($minutesAgo * 60 * 10000);

            $packageChanges = $this->fetchPackageChanges($timestamp);
            $packagesToAddApi = $packageChanges['packagesToAdd'];
            $packagesToRemoveApi = $packageChanges['packagesToRemove'];

            $packagesToAdd = array_unique(array_merge($packagesToAddDb, $packagesToAddApi));
            $packagesToRemove = array_unique(array_merge($packagesToRemoveDb, $packagesToRemoveApi));

            $packageAddDbCount = count($packagesToAddDb);
            $packageRemoveDbCount = count($packagesToRemoveDb);
            $packageAddApiCount = count($packagesToAddApi);
            $packageRemoveApiCount = count($packagesToRemoveApi);
            $packageAddCount = count($packagesToAdd);
            $packageRemoveCount = count($packagesToRemove);

            echo 'Add: '.$packageAddCount.' (from DB: '.$packageAddDbCount.', from API: '.$packageAddApiCount.')<br>';
            echo 'Remove: '.$packageRemoveCount.' (from DB: '.$packageRemoveDbCount.', from API: '.$packageRemoveApiCount.')';

            dd($packagesToAdd);

            $deletedPackages = 0;

            foreach ($packagesToRemove as $packageToRemove) {

                $deleteCount = PackagistPackage::where('slug', $packageToRemove)->delete();
                $deletedPackages = $deletedPackages + $deleteCount;

            }

            echo '<br><br>'.$deletedPackages.' packages deleted from database.';

        } else {

            $packagesToAdd = json_decode($this->getAllPackages());

        }

        $batchSize = 100;
        $packagesChunks = array_chunk($packagesToAdd, $batchSize);

        foreach ($packagesChunks as $chunk) {
            PackagistPackagesUpdate::dispatch($chunk);
        }

    }
}
