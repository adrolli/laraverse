<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;
use App\Traits\ErrorHandler;
use Illuminate\Support\Str;

trait GetSearch
{
    use ErrorHandler, GetSearchPage, RepositoryCreate;

    public function getGitHubSearch()
    {

        try {

            foreach (config('app.github_search') as $keyPhrase) {
                $page = 1;
                $perPage = 100;

                $searchResults = $this->getGitHubSearchPage($keyPhrase, $perPage, $page);

                $count = $searchResults['total_count'];
                $pages = $count / $perPage;
                $nextpage = 2;

                if ($pages < $nextpage) {
                    $githubSearch = new GithubSearch;
                    $githubSearch->keyphrase = $keyPhrase;
                    $githubSearch->count = $count;
                    $githubSearch->pages = $pages;
                    $githubSearch->nextpage = $nextpage;
                    $githubSearch->save();
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
