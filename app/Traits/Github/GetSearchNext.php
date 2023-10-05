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

            $githubSearch = GithubSearch::select('*')
                ->inRandomOrder()
                ->first();

            if ($githubSearch) {
                $keyPhrase = $githubSearch->keyphrase;
                $count = $githubSearch->count;
                $pages = $githubSearch->pages;
                $nextPage = $githubSearch->nextpage;

                activity()->log("GitHub Worker starts on keyPhrase: {$keyPhrase}");

                $searchResults = $this->getGitHubSearchPage($keyPhrase, $perPage, $nextPage);

                $repositorySource = 'github-search-'.Str::slug($keyPhrase);

                foreach ($searchResults['items'] as $item) {
                    $this->createGitHubRepository($item, $repositorySource);
                }

                if ($count == 0) {
                    $count = $searchResults['total_count'];
                    $pages = $count / $perPage;
                    $githubSearch->count = $count;
                    $githubSearch->pages = $pages;
                }

                if ($pages == $nextPage) {
                    $githubSearch->delete();
                } else {
                    $githubSearch->nextpage = $nextPage + 1;
                    $githubSearch->save();
                }

            }
        } catch (\Exception $e) {

            $this->handleError('GitHub Search Next', $e);

            return null;
        }
    }
}
