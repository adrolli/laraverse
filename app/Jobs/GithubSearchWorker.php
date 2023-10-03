<?php

/*
|--------------------------------------------------------------------------
| Laraverse Github Worker
|--------------------------------------------------------------------------
|
| This job should run hourly to manage all updates (create, update, and
| delete) from the Github API and write them to Repositories model.
| It starts GithubUpdate, GithubSearch and GithubDelete in batch.
|
*/

namespace App\Jobs;

use Adrolli\FilamentJobManager\Traits\JobProgress;
use App\Traits\Github\GetRateLimits;
use App\Traits\Github\GetSearch;
use App\Traits\Github\GetSearchesInQueue;
use App\Traits\Github\GetSearchNext;
use App\Traits\Github\GetSearchPage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GithubSearchWorker implements ShouldQueue
{
    use Dispatchable, GetRateLimits, GetSearch, GetSearchesInQueue, GetSearchNext,
        GetSearchPage, InteractsWithQueue, JobProgress, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    public $batch;

    public function __construct()
    {
        $this->tries = config('app.laraverse_tries');
        $this->timeout = config('app.laraverse_timeout');
        $this->maxExceptions = config('app.laraverse_exceptions');
        $this->backoff = config('app.laraverse_backoff');
        $this->batch = config('app.laraverse_batch');
    }

    public function handle(): void
    {
        activity()->log('GitHub Search started');

        $this->setProgress(0);

        $lockName = 'github-worker-lock';
        $maxLockTimeInSeconds = 3600;

        $perPage = config('app.laraverse_github_pages');

        $lock = Cache::lock($lockName, $maxLockTimeInSeconds);

        if ($lock->get()) {

            $pagesInQueue = $this->getGitHubSearchesInQueue();

            $rates = $this->getGithubRateLimits();

            $currentLimits = $rates['search']['remaining'];

            $this->setProgress(10);

            if ($currentLimits >= 1 and $pagesInQueue == true) {

                $this->getGitHubSearchNext($perPage);

                $this->setProgress(99);

                activity()->log('GitHub Search Pages ran successfully');

            } elseif ($currentLimits >= 30 and $pagesInQueue == false) {

                $this->getGitHubSearch();

                $this->setProgress(99);

                activity()->log('GitHub Search ran successfully');

            } elseif ($pagesInQueue == true) {

                activity()->log("GitHub Search has only {$currentLimits} left for doing pages");

            } elseif ($pagesInQueue == false) {

                activity()->log("GitHub Search has only {$currentLimits} left for doing searches");

            }

        } else {

            activity()->log('GitHub Search is already running');

        }

        // Todo, was $lock->release();
        $lock->forceRelease();

        activity()->log('GitHub Search lock released');

        $this->setProgress(100);

    }
}
