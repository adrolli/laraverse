<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;
use App\Models\SearchWorker;
use App\Traits\ErrorHandler;
use Illuminate\Support\Str;

trait GetSearch
{
    use ErrorHandler, GetSearchPage, RepositoryCreate, SearchQueries;

    public function getGitHubSearch()
    {

        try {

            $searchQueries = SearchWorker::all();

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

                if ($github == true) {

                    $page = 1;
                    $nextpage = 2;
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

                    $searchResults = $this->getGitHubSearchPage($query, $perPage, $page);

                    $repositorySource = 'github-search-'.Str::slug($keyPhrase);

                    foreach ($searchResults['items'] as $item) {
                        $this->createGitHubRepository($item, $repositorySource);
                    }

                    $count = $searchResults['total_count'];
                    $pages = $count / $perPage;

                    if ($count > 1000) {

                        // do weird stuff

                    }

                    if ($count > 100 && $count < 1000) {

                        // make all pages

                    }

                    $queries = $this->generateSearchQueries($keyPhrase, $count);

                    activity()->log("Create new GithubSearches to get {$count} results for {$query}");

                    if ($pages > $nextpage) {
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

        } catch (\Exception $e) {

            $this->handleError('GitHub Search', $e);

            return null;
        }
    }
}
