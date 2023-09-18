<?php

namespace App\Traits\Packagist;

use App\Models\PackagistPackage;
use Exception;

trait PackageUpdate
{
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

            activity()->log("Packagist package {$packageName} update failed: ".$e);

        }
    }
}
