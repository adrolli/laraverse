<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;

trait GetSearch
{
    use ErrorHandler, GetSearchPage, RepositoryCreate;

    public function getGitHubSearch()
    {

        try {

            foreach (config('app.github_search') as $keyPhrase) {
                $page = 1;
                $perPage = 10;

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

                foreach ($searchResults['items'] as $item) {
                    $this->createGitHubRepository($item);
                }

            }

        } catch (\Exception $e) {

            $this->handleApiError($e, 'GitHub Search');

            return null;
        }
    }
}
