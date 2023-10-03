<?php

namespace App\Traits\Github;

use App\Models\RepositorySource;
use App\Traits\ErrorHandler;

trait RepoCreateSource
{
    use ErrorHandler;

    public function createGitHubSource($repositorySource)
    {

        try {

            $type = RepositorySource::firstOrCreate(
                ['slug' => $repositorySource], [
                    'title' => ucfirst($repositorySource),
                    'slug' => $repositorySource,
                ]);

            return $type;

        } catch (\Exception $e) {

            $this->handleError('GitHub Source', $e);

            return null;
        }
    }
}
