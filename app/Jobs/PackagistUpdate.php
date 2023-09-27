<?php

/*
|--------------------------------------------------------------------------
| Laraverse Packagist Updater
|--------------------------------------------------------------------------
|
| This job is triggered by PackagistWorker. It works through a batch
| of packages and updates the packages with data from Packagist API,
| to the PackagistPackages model. The batch size is set in .env
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\Packagist\GetApiPackage;
use App\Traits\Packagist\PackageUpdate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistUpdate implements ShouldQueue
{
    use Dispatchable, GetApiPackage, InteractsWithQueue, JobProgress,
        PackageUpdate, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    protected $packageNames;

    public function __construct(array $packageNames)
    {
        $this->tries = config('app.laraverse_tries');
        $this->timeout = config('app.laraverse_timeout');
        $this->maxExceptions = config('app.laraverse_exceptions');
        $this->backoff = config('app.laraverse_backoff');
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
            if ($packageData) {
                $this->updatePackage($packageData);
            }
        }

        $this->setProgress(100);

    }
}
