<?php

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Models\PackagistPackage;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistAll;
use App\Traits\GetPackagistDiff;
use App\Traits\GetPackagistUpdates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistUpdate implements ShouldQueue
{
    use Dispatchable, ErrorHandler, GetPackagistAll, GetPackagistDiff, GetPackagistUpdates, InteractsWithQueue, JobProgress, Queueable, SerializesModels;

    public $tries = 5;

    public $timeout = 600;

    //  public $maxExceptions = 3;

    //  public $backoff = 120;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $this->setProgress(0);

        $packageCount = PackagistPackage::count();

        $this->setProgress(5);

        if ($packageCount > 0) {

            //Works fine for new/delete, but does no updates
            //$packagesDiff = $this->compareWithDatabase();
            //$packagesToAdd = $packagesDiff['packagesToAdd'];
            //$packagesToRemove = $packagesDiff['packagesToRemove];

            $packageChanges = $this->fetchPackageChanges(1);
            $packagesToAdd = $packageChanges['packagesToAdd'];
            $packagesToRemove = $packageChanges['packagesToRemove'];

            $packageCount = array_count_values($packagesToAdd);

            throw new \Exception("Something went wrong, there are $packageCount packages in database.");
            $this->setProgress(10);

            // Todo:
            // - Packages to update against rules
            // - Merge to array $packagesToAdd

        } else {

            $packagesToAdd = json_decode($this->getAllPackages());

        }

        $batchSize = 50;

        $packagesChunks = array_chunk($packagesToAdd, $batchSize);

        $chunkCount = count($packagesChunks);
        $stepSize = 80 / $chunkCount;
        $currentProgress = 15;
        $this->setProgress(15);

        foreach ($packagesChunks as $chunk) {

            PackagistPackagesUpdate::dispatch($chunk);

            $currentProgress = $currentProgress + $stepSize;
            $this->setProgress($currentProgress);

        }

        //$this->setProgress(100);

    }

    /* use Batchable instead of Queueable
    public function processPackages()
    {
        $packageNames = $this->getAllPackages();
        $batchSize = 50;

        $packagesChunks = array_chunk($packageNames, $batchSize);

        $batch = Bus::batch([]);

        foreach ($packagesChunks as $chunk) {
            $batch->add(new PackagistPackagesUpdate($chunk));
        }

        $batch->dispatch();
    }
    */

}
