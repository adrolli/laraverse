<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;
use App\Traits\ErrorHandler;
use Illuminate\Support\Str;

trait GetSearch
{
    use ErrorHandler, GetSearchPage, RepositoryCreate, SearchQueries;

    public function getGitHubSearch()
    {

        try {

            foreach (config('app.github_search') as $keyPhrase) {
                $page = 1;
                $nextpage = 2;
                $perPage = config('app.laraverse_github_pages');

                $searchResults = $this->getGitHubSearchPage($keyPhrase, $perPage, $page);

                $count = $searchResults['total_count'];
                $pages = $count / $perPage;

                $queries = $this->generateSearchQueries($keyPhrase, $count);

                activity()->log("Create new GithubSearches to get {$count} results for {$keyPhrase}");

                if ($pages > $nextpage) {
                    foreach ($queries as $query) {
                        activity()->log("Create a new GithubSearch with query: {$query}");

                        $searchResultsInner = $this->getGitHubSearchPage($query, $perPage, $page);

                        $countInner = $searchResultsInner['total_count'];
                        $pagesInner = $countInner / $perPage;

                        $githubSearch = new GithubSearch;
                        $githubSearch->keyphrase = $query;
                        $githubSearch->count = $countInner;
                        $githubSearch->pages = $pagesInner;
                        $githubSearch->nextpage = $nextpage;
                        $githubSearch->save();
                    }
                }

                $repositorySource = 'github-search-'.Str::slug($keyPhrase);

                foreach ($searchResults['items'] as $item) {
                    $this->createGitHubRepository($item, $repositorySource);
                }

            }

        } catch (\Exception $e) {

            $this->handleError('GitHub Search', $e);

            return null;
        }
    }
}
