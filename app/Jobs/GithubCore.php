<?php

/*
|--------------------------------------------------------------------------
| Laraverse Github Core
|--------------------------------------------------------------------------
|
| This job is dispatched by GithubWorker. It checks for rate
| limits, uses a github url to fetch the full repository
| information and writes all results to database.
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\ErrorHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class GithubCore implements ShouldQueue
{
    use Dispatchable, ErrorHandler, InteractsWithQueue, JobProgress, Queueable, SerializesModels;

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

        Redis::throttle('githubcore')
            ->allow(30)
            ->every(60)
            ->block(10)
            ->then(function () {

                activity()->log('GitHub Core ended');

                $this->setProgress(100);

            });

    }
}
