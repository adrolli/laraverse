<?php

namespace App\Jobs;

use App\Models\PackagistPackage;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistAll;
use App\Traits\GetPackagistDiff;
use Croustibat\FilamentJobsMonitor\Traits\QueueProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, QueueProgress, GetPackagistAll, ErrorHandler, GetPackagistDiff;

    public $tries = 5;

    public $maxExceptions = 3;

    public $timeout = 600;

    public $backoff = 120;

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

            $packagesDiff = $this->compareWithDatabase();
            $packagesToAdd = $packagesDiff['packagesToAdd'];

            $this->setProgress(10);

            // Todo:
            // - Packages to update against rules
            // - Merge to array $packagesToAdd

            $this->setProgress(15);

        } else {

            $packagesToAdd = $this->getAllPackages();

            $this->setProgress(15);

        }

        $batchSize = 50;

        $packagesChunks = array_chunk($packagesToAdd, $batchSize);

        $chunkCount = count($packagesChunks);
        $stepSize = 80 / $chunkCount;
        $currentProgress = 15;

        foreach ($packagesChunks as $chunk) {
            PackagistPackagesUpdate::dispatch($chunk);

            $currentProgress = $currentProgress + $stepSize;
            $this->setProgress($currentProgress);

        }

        $this->setProgress(100);

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
