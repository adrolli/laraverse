<?php

namespace App\Traits;

use App\Models\PackagistPackage;

trait RemovePackagistPackages
{
    public function removePackages($packagesDiffDb, $packageChanges)
    {

        $packagesToRemoveDb = $packagesDiffDb['packagesToRemove'];
        $packagesToRemoveApi = $packageChanges['packagesToRemove'];
        $packagesToRemove = array_unique(array_merge($packagesToRemoveDb, $packagesToRemoveApi));

        $packageRemoveDbCount = count($packagesToRemoveDb);
        $packageRemoveApiCount = count($packagesToRemoveApi);
        $packageRemoveCount = count($packagesToRemove);

        activity()->log("{$packageRemoveCount} Packagist packages to remove, {$packageRemoveDbCount} from DB and {$packageRemoveApiCount} from API.");

        foreach ($packagesToRemove as $packageToRemove) {
            $packageDeleted = PackagistPackage::where('slug', $packageToRemove)->delete();
            if ($packageDeleted == 1) {

                activity()->log("Packagist package {$packageToRemove} deleted");

            }
        }
    }
}
