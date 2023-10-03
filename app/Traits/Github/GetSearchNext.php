<?php

namespace App\Traits\Github;

use App\Models\GithubSearch;
use App\Traits\ErrorHandler;
use Illuminate\Support\Str;

trait GetSearchNext
{
    use ErrorHandler, GetSearchPage, RepositoryCreate;

    public function getGitHubSearchNext($perPage)
    {

        try {

            $githubSearches = GithubSearch::select('*')
                ->inRandomOrder()
                ->first();

            if ($githubSearches) {
                foreach ($githubSearches as $githubSearch) {
                    $keyPhrase = $githubSearch->keyphrase;
                    $pages = $githubSearch->pages;
                    $nextPage = $githubSearch->nextpage;
                }
            }

            $searchResults = $this->getGitHubSearchPage($keyPhrase, $perPage, $nextPage);

            $repositorySource = 'github-search-'.Str::slug($keyPhrase);

            foreach ($searchResults['items'] as $item) {
                $this->createGitHubRepository($item, $repositorySource);
            }

            if ($pages == $nextPage) {
                $githubSearches->delete();
            } else {
                $githubSearches->nextpage = $nextPage + 1;
                $githubSearches->save();
            }

        } catch (\Exception $e) {

            $this->handleError('GitHub Search Next', $e);

            return null;
        }
    }
}
