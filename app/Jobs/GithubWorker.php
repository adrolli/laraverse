<?php

/*
|--------------------------------------------------------------------------
| Laraverse Github Worker
|--------------------------------------------------------------------------
|
| This job should run minutely to manage all updates (create, update, and
| delete) from the Github API and write them to Repositories model.
| It starts GithubUpdate, Search, Discover and Delete in batch.
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\ErrorHandler;
use App\Traits\Github\GetRateLimits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GithubWorker implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, ErrorHandler, GetRateLimits, InteractsWithQueue,
        JobProgress, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    public $batch;

    public function __construct()
    {
        $this->tries = config('app.laraverse_github_tries');
        $this->timeout = config('app.laraverse_github_timeout');
        $this->maxExceptions = config('app.laraverse_github_exceptions');
        $this->backoff = config('app.laraverse_github_backoff');
        $this->batch = config('app.laraverse_github_batch');
    }

    public function handle(): void
    {
        $this->setProgress(0);

        activity()->log('GitHub Worker started');

        $rates = $this->getGithubRateLimits();
        $coreLimit = $rates['core']['remaining'];
        $searchLimit = $rates['search']['remaining'];

        $this->setProgress(30);

        if ($coreLimit >= 1) {

            activity()->log("GitHub Worker starts Core Job with {$coreLimit}");

            GithubCore::dispatch($coreLimit);

        }

        $this->setProgress(60);

        if ($searchLimit >= 1) {

            activity()->log("GitHub Worker starts Core Job with {$searchLimit}");

            GithubSearch::dispatch($searchLimit);

        }

        activity()->log('GitHub Worker ended');

        $this->setProgress(100);

    }
}
