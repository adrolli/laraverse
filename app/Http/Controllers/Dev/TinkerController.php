<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Jobs\PackagistPackagesUpdate;
use App\Models\PackagistPackage;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistAll;
use App\Traits\GetPackagistDiff;
use App\Traits\GetPackagistPackage;
use App\Traits\GetPackagistUpdates;
use App\Traits\RemovePackagistPackages;
use App\Traits\UpdatePackagistPackage;
use Illuminate\Queue\SerializesModels;

class TinkerController extends Controller
{
    use ErrorHandler, GetPackagistAll, GetPackagistDiff, GetPackagistPackage, GetPackagistUpdates, RemovePackagistPackages, SerializesModels, UpdatePackagistPackage;

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

            $hoursAgo = 24;
            $timestamp = (int) (microtime(true) * 10000) - ($hoursAgo * 60 * 60 * 10000);

            $packageChanges = $this->fetchPackageChanges($timestamp);
            $packagesToAddApi = $packageChanges['packagesToAdd'];

            $packagesToAdd = array_unique(array_merge($packagesToAddDb, $packagesToAddApi));

            $this->removeDevBranches($packagesToAdd);

            $packageAddDbCount = count($packagesToAddDb);
            $packageAddApiCount = count($packagesToAddApi);
            $packageAddCount = count($packagesToAdd);

            activity()->log("{$packageAddCount} Packagist packages to update, {$packageAddDbCount} from DB and {$packageAddApiCount} from API.");

            $this->removePackages($packagesDiffDb, $packageChanges);

        } else {

            $packagesToAdd = json_decode($this->getAllPackages());
            $packageAddCount = count($packagesToAdd);

            activity()->log("{$packageAddCount} Packagist packages to initialize.");

        }

        $batchSize = 25;
        $packagesChunks = array_chunk($packagesToAdd, $batchSize);

        foreach ($packagesChunks as $chunk) {
            PackagistPackagesUpdate::dispatch($chunk);

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
