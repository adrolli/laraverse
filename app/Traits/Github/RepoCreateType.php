<?php

namespace App\Traits\Github;

use App\Models\RepositoryType;
use App\Traits\ErrorHandler;

trait RepoCreateType
{
    use ErrorHandler;

    public function createGitHubType($repositoryContents, $createRepo)
    {

        try {

            if ($repositoryContents['artisan'] != false and $repositoryContents['app'] != false) {
                $settype = 'app';
            } elseif ($createRepo['template'] === true) {
                $settype = 'template';
            } elseif ($repositoryContents['src'] != false and $repositoryContents['composer.json'] != false) {
                $settype = 'package';
            } else {
                $settype = 'unknown';
            }

            $type = RepositoryType::firstOrCreate(
                ['slug' => $settype], [
                    'title' => ucfirst($settype),
                    'slug' => $settype,
                ]);

            return $type;

        } catch (\Exception $e) {

            $this->handleError('GitHub Type', $e);

            return null;
        }
    }
}
