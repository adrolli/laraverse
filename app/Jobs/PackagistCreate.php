<?php

/*
|--------------------------------------------------------------------------
| Laraverse Packagist Creator
|--------------------------------------------------------------------------
|
| This job is triggered by PackagistWorker. It works through a batch
| of packages and creates the packages, fetched from Packagist API,
| in the PackagistPackages model. The batch size is set in .env
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\Packagist\GetApiPackage;
use App\Traits\Packagist\PackageCreate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistCreate implements ShouldQueue
{
    use Dispatchable, GetApiPackage, InteractsWithQueue, JobProgress,
        PackageCreate, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    protected $packageNames;

    public function __construct(array $packageNames)
    {
        $this->tries = config('app.laraverse_packagist_tries');
        $this->timeout = config('app.laraverse_packagist_timeout');
        $this->maxExceptions = config('app.laraverse_packagist_exceptions');
        $this->backoff = config('app.laraverse_packagist_backoff');
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
                $this->createPackage($packageData);
            }
        }

        $this->setProgress(100);

    }
}
