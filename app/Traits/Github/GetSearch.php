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
                $perPage = config('app.laraverse_github_pages');

                $searchResults = $this->getGitHubSearchPage($keyPhrase, $perPage, $page);

                $count = $searchResults['total_count'];
                $pages = $count / $perPage;
                $nextpage = 2;

                $queries = $this->generateSearchQueries($keyPhrase, $count);

                activity()->log("Create new GithubSearches to get {$count} results for {$keyPhrase}");

                foreach ($queries as $query) {

                    if ($pages > $nextpage) {

                        activity()->log("Create a new GithubSearch with query: {$query}");

                        $searchResults = $this->getGitHubSearchPage($query, $perPage, $page);

                        $githubSearch = new GithubSearch;
                        $githubSearch->keyphrase = $query;
                        $githubSearch->count = $count;
                        $githubSearch->pages = $pages;
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

            $this->handleApiError('GitHub Search', $e);

            return null;
        }
    }
}
