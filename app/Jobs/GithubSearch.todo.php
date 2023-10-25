<?php

/*
|--------------------------------------------------------------------------
| Laraverse Github Search
|--------------------------------------------------------------------------
|
| This job is dispatched by GithubWorker. It checks for rate
| limits, fetches the search pages and full repository
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
use Illuminate\Support\Str;

class GithubSearch implements ShouldQueue
{
    use Dispatchable, ErrorHandler, InteractsWithQueue, JobProgress, Queueable, SerializesModels;

    public $tries;

    public $timeout;

    public $maxExceptions;

    public $backoff;

    public $batch;

    public $searchLimit;

    public function __construct($searchLimit)
    {
        $this->tries = config('app.laraverse_github_tries');
        $this->timeout = config('app.laraverse_github_timeout');
        $this->maxExceptions = config('app.laraverse_github_exceptions');
        $this->backoff = config('app.laraverse_github_backoff');
        $this->batch = config('app.laraverse_github_batch');
        $this->searchLimit = $searchLimit;
    }

    public function handle(): void
    {
        $this->setProgress(0);

        $searchLimit = $this->searchLimit;
        $perPage = config('app.laraverse_github_pages');

        $searchWorker = SearchWorker::where('waits', true)->where('githubsearch', true);

        $remainingKeywords = $searchWorker->count();
        $searchQuery = $searchWorker->first();

        if ($remainingKeywords === 0) {
            SearchWorker::update(['waits' => true]);
        }

        $this->setProgress(3);

        $topicsValue = '';
        $readmeValue = '';
        $forksValue = '';
        $starrValue = '';

        $keyPhrase = $searchQuery->keyphrase;
        $github = $searchQuery->githubsearch;
        $topics = $searchQuery->githubtopics;
        $readme = $searchQuery->githubreadme;
        $forks = $searchQuery->githubforks;
        $starr = $searchQuery->githubstarred;
        $waits = $searchQuery->githubwaiting;

        $repositorySource = 'github-search-'.Str::slug($keyPhrase);

        $perPage = config('app.laraverse_github_pages');

        if ($topics == true) {
            $topicsValue = ',topics';
        }

        if ($readme == true) {
            $readmeValue = ',readme';
        }

        if ($forks == true) {
            $forksValue = '+fork:true';
        }

        if ($starr == true) {
            $starrValue = '+stars:>=1';
        }

        $query = "{$keyPhrase}+in:name,description{$topicsValue}{$readmeValue}{$forksValue}";

        $searchResults = $this->getGitHubSearchPage($query, $perPage, 1);

        foreach ($searchResults['items'] as $item) {
            $this->createGitHubRepository($item, $repositorySource);
        }

        $searchLimit = $searchLimit - 1;

        $count = $searchResults['total_count'];
        $pages = $count / $perPage;

        // if searchLimit is enough, do all pages for the keyword
        // if searchlimit is not enough do partly or make others instead

        if ($searchLimit <= 1) {

            // do spend the rest

        } else {

            // write the currend job to db

        }

        if ($count > 100 && $count < 1000) {

            for ($next = 2; $next <= $pages; $next++) {

                $searchResults = $this->getGitHubSearchPage($query, $perPage, $next);

                foreach ($searchResults['items'] as $item) {
                    $this->createGitHubRepository($item, $repositorySource);
                }

            }

        } elseif ($count > 1000) {

            // todo

        }

        // Todo: this may not work as expected, test
        $searchQuery->update(['waits' => false]);

        activity()->log("GitHub Worker finished search for keyword {$keyPhrase}");

        $this->setProgress(100);

    }
}
