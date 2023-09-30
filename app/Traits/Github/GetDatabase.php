<?php

namespace App\Traits\Github;

use App\Models\Repository;

trait GetDatabase
{
    public function getGithubRepositoriesFromDb()
    {

        try {

            $localPackageSlugs = Repository::pluck('slug')->toArray();

            return $localPackageSlugs;

        } catch (\Exception $e) {

            activity()->log('Unable to fetch GitHub repositories from DB: '.$e);

        }

    }
}
