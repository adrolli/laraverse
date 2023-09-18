<?php

namespace App\Traits\Packagist;

use App\Models\PackagistPackage;

trait GetDatabase
{
    public function getPackagistPackagesFromDb()
    {

        try {

            $localPackageSlugs = PackagistPackage::pluck('slug')->toArray();

            return $localPackageSlugs;

        } catch (\Exception $e) {

            activity()->log('Unable to fetch Packagist packages from DB: '.$e);

        }

    }
}
