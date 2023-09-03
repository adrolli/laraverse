<?php

namespace App\Http\Controllers\Laraverse;

use App\Http\Controllers\Controller;
use App\Jobs\PackagistPackagesUpdate;
use App\Models\PackagistPackage;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistAll;
use App\Traits\GetPackagistDiff;
use Illuminate\Queue\SerializesModels;

class PackagistController extends Controller
{
    use ErrorHandler, GetPackagistAll, GetPackagistDiff, SerializesModels;

    public function __invoke()
    {
        $this->updateAllPackages();
    }

    public function updateAllPackages()
    {

        $packageCount = PackagistPackage::count();

        if ($packageCount > 0) {

            $packagesDiff = $this->compareWithDatabase();

            $packagesToAdd = $packagesDiff['packagesToAdd'];

            // Todo:
            // - Packages to update against rules
            // - Merge to array $packagesToAdd

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
