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
use App\Models\GithubSearch;
use App\Traits\ErrorHandler;
use App\Traits\Github\GetRateLimits;
use App\Traits\Github\GetSearch;
use App\Traits\Github\GetSearchNext;
use App\Traits\Github\GetSearchPage;
use App\Traits\Github\RepositoryCreate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GithubSearchWorker implements ShouldQueue
{
    use Dispatchable, ErrorHandler, GetRateLimits, GetSearch,
        GetSearchNext, GetSearchPage, InteractsWithQueue, JobProgress, Queueable,
        RepositoryCreate, SerializesModels;

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
        activity()->log('GitHub Search started');

        $this->setProgress(0);

        $lockName = 'github-worker-lock';
        $maxLockTimeInSeconds = config('app.laraverse_github_locktime');

        $perPage = config('app.laraverse_github_pages');

        $lock = Cache::lock($lockName, $maxLockTimeInSeconds);

        $this->setProgress(1);

        if ($lock->get()) {

            $rates = $this->getGithubRateLimits();
            $currentLimits = $rates['search']['remaining'];

            $this->setProgress(2);

            if ($currentLimits >= config('app.laraverse_github_searchlimit')) {

                $remainingKeywords = SearchWorker::where('done', false)->count();

                if ($remainingKeywords === 0) {
                    SearchWorker::update(['done' => false]);
                }

                $searchQueries = SearchWorker::all();

                $this->setProgress(3);

                // foreach but do only first keyword
                foreach ($searchQueries as $searchQuery) {

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

                    if (($github == true) && ($waits == false)) {

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
                            $starrValue = '+fork:true';
                        }

                        $query = "{$keyPhrase}+in:name,description{$topicsValue}{$readmeValue}{$forksValue}";

                        $searchResults = $this->getGitHubSearchPage($query, $perPage, 1);

                        foreach ($searchResults['items'] as $item) {
                            $this->createGitHubRepository($item, $repositorySource);
                        }

                        $count = $searchResults['total_count'];
                        $pages = $count / $perPage;

                        if ($count > 100 && $count < 1000) {

                            for ($next = 2; $next <= $pages; $next++) {

                                $searchResults = $this->getGitHubSearchPage($query, $perPage, $next);

                                foreach ($searchResults['items'] as $item) {
                                    $this->createGitHubRepository($item, $repositorySource);
                                }

                            }

                        } elseif ($count > 1000) {

                            // todo



                        } else {

                            activity()->log("GitHub Worker finished search for keyword {$keyPhrase}");

                            // todo created repos?
                        }

                        SearchWorker::where('keyword', $lastKeyword)->update(['done' => true]);

                    } else {

                        activity()->log("Skipping keyword, next...");

                        // Todo: github not true, do the next one

                    }

                }

            } else {

                activity()->log("GitHub Search is rate limited at {$currentLimits}");

            }

        } else {

            activity()->log('GitHub Search is already running');

        }

        $lock->forceRelease();

        activity()->log('GitHub Search lock released');

        $this->setProgress(100);

    }
}


            /*
                    $queries = $this->generateSearchQueries($keyPhrase, $count);

                    activity()->log("Create new GithubSearches to get {$count} results for {$query}");

                        foreach ($queries as $query) {
                            // to many requests, triggering api limits, save search without count and pages
                            // then starting from page 1 and update information then
                            //$searchResultsInner = $this->getGitHubSearchPage($query, $perPage, $page);

                            //$countInner = $searchResultsInner['total_count'];
                            //$pagesInner = $countInner / $perPage;

                            //if ($pagesInner > $nextpage) {
                            activity()->log("Create a new GithubSearch with query: {$query}");

                            $githubSearch = new GithubSearch;
                            $githubSearch->keyphrase = $query;
                            $githubSearch->count = 0;
                            $githubSearch->pages = 0;
                            $githubSearch->nextpage = $page;
                            $githubSearch->save();
                            //}
                        }
                    }

                }

            }

            $githubSearches = GithubSearch::all();
            $jobsInQueue = count($githubSearches);



            if ($currentLimits >= 1 and $jobsInQueue > 0) {

                activity()->log("GitHub Search Pages started working on {$jobsInQueue} pages in queue");

                $this->getGitHubSearchNext($perPage);

                $this->setProgress(99);

                activity()->log('GitHub Search Pages ran successfully');

            } elseif ($currentLimits >= 25) {

                $this->getGitHubSearch();

                $this->setProgress(99);

                activity()->log('GitHub Search ran successfully');

            }

        }
