<?php

namespace App\Traits\Packagist;

use App\Models\PackagistPackage;
use Exception;

trait PackageUpdate
{
    public function updatePackage($packageDetails)
    {
        $packageName = 'undefined';

        try {

            $packageName = $packageDetails['package']['name'];

            activity()->log("Packagist package {$packageName} is about to update");

            $parts = explode('/', $packageName);
            $vendorPart = $parts[0];
            $packagePart = $parts[1];

            activity()->log("Vendor {$vendorPart} and Package {$packagePart} known");

            if ($vendorPart === $packagePart) {
                $packageTitle = ucwords(str_replace('-', ' ', $vendorPart));
            } else {
                $packageTitle = ucwords(str_replace('-', ' ', $vendorPart)).' '.ucwords(str_replace('-', ' ', $packagePart));
            }

            activity()->log("Package title {$packageTitle} known");

            $dataToFill = [
                'data' => $packageDetails['package'],
                'title' => $packageTitle,
                'slug' => $packageName,
                'type' => $packageDetails['package']['type'],
                'repository_updated' => false,
            ];

            activity()->log("Package type {$packageDetails['package']['type']} known");

            PackagistPackage::updateOrCreate(
                ['slug' => $dataToFill['slug']],
                $dataToFill
            );

            activity()->log("Packagist package {$packageName} updated");

        } catch (Exception $e) {

            activity()->log("Packagist package {$packageName} update failed: ".$e);

        }
    }
}
