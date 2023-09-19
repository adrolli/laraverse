<?php

namespace App\Traits\Packagist;

use App\Models\PackagistPackage;
use Exception;

trait PackageDelete
{
    public function deletePackage($packageToRemove)
    {
        $packageToRemove = 'undefined';

        try {

            $packageDeleted = PackagistPackage::where('slug', $packageToRemove)->delete();
            if ($packageDeleted == 1) {

                activity()->log("Packagist package {$packageToRemove} deleted");

            }

        } catch (Exception $e) {

            activity()->log("Packagist package {$packageToRemove} deletion failed: ".$e);

        }
    }
}
