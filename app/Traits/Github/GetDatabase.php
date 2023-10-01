<?php

namespace App\Traits\Github;

use App\Models\Repository;
use Illuminate\Support\Str;

trait GetDatabase
{
    public function getGithubRepositoriesFromDb($keyPhrase)
    {

        try {

            $slug = 'github-search-'.Str::slug($keyPhrase);

            $slugsArray = Repository::whereHas('repositorySource', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->pluck('slug')->toArray();

            return $slugsArray;

        } catch (\Exception $e) {

            activity()->log('Unable to fetch GitHub repositories from DB: '.$e);

        }

    }
}
