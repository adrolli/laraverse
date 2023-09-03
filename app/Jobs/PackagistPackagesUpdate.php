<?php

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\ErrorHandler;
use App\Traits\GetPackagistPackage;
use App\Traits\UpdatePackagistPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistPackagesUpdate implements ShouldQueue
{
    use Dispatchable, ErrorHandler, GetPackagistPackage, InteractsWithQueue, JobProgress, Queueable, SerializesModels, UpdatePackagistPackage;

    public $tries = 5;

    public $maxExceptions = 3;

    public $timeout = 300;

    public $backoff = 60;

    protected $packageNames;

    public function __construct(array $packageNames)
    {
        $this->packageNames = $packageNames;
    }

    public function handle()
    {
        $progress = 0;
        $packages = $this->packageNames;
        $stepsize = 100 / count($packages);

        foreach ($packages as $package) {

            $this->setProgress($progress);
            $progress = $progress + $stepsize;

            $packageData = $this->getPackage($package);
            $this->updatePackage($packageData);
        }

        $this->setProgress(100);

    }
}
