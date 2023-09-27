<?php

/*
|--------------------------------------------------------------------------
| Laraverse Packagist Deleter
|--------------------------------------------------------------------------
|
| This job is triggered by PackagistWorker. It works through a batch
| of packages and deletes the packages, fetched from Packagist API,
| in the PackagistPackages model. The batch size is set in .env
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Models\PackagistPackage;
use App\Traits\Packagist\GetApiPackage;
use App\Traits\Packagist\PackageDelete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PackagistDelete implements ShouldQueue
{
    use Dispatchable, GetApiPackage, InteractsWithQueue, JobProgress,
        PackageDelete, Queueable, SerializesModels;

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

            $packageDeleted = PackagistPackage::where('slug', $package)->delete();

            if ($packageDeleted == 1) {

                activity()->log("Packagist package {$package} deleted");
            }

        }

        $this->setProgress(100);

    }
}
