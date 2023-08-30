<?php

namespace App\Traits;

use App\Models\PackagistPackage;

trait GetPackagistDiff
{
    public function compareWithDatabase()
    {
        $apiPackageNames = $this->getAllPackages();

        $dbPackageSlugs = PackagistPackage::pluck('slug')->toArray();

        $packagesToAdd = array_diff($apiPackageNames, $dbPackageSlugs);
        $packagesToRemove = array_diff($dbPackageSlugs, $apiPackageNames);

        return [
            'packagesToAdd' => $packagesToAdd,
            'packagesToRemove' => $packagesToRemove,
        ];
    }
}
