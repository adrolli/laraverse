<?php

namespace App\Traits\Github;

use App\Models\RepositorySource;

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

            $this->handleApiError($e, 'GitHub Source');

            return null;
        }
    }
}
