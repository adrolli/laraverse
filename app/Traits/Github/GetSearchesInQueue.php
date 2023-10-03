<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;
use App\Traits\ErrorHandler;

trait GetSearchesInQueue
{
    use ErrorHandler;

    public function getGitHubSearchesInQueue()
    {

        try {

            $githubSearches = GithubSearch::all();

            $allPages = 0;
            $allPagesDone = 0;

            if ($githubSearches) {
                foreach ($githubSearches as $githubSearch) {
                    $pages = $githubSearch->pages;
                    $nextPage = $githubSearch->nextpage;
                    $pagesDone = $nextPage - 1;
                    $allPages = $allPages + $pages;
                    $allPagesDone = $allPagesDone + $pagesDone;
                }
            }

            $allPagesPending = $allPages - $allPagesDone;

            return $allPagesPending;

        } catch (\Exception $e) {

            $this->handleError('GitHub Search', $e);

            return null;
        }
    }
}
