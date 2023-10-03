<?php

namespace App\Traits\Github;

use App\Models\RepositoryTag;
use App\Traits\ErrorHandler;

trait RepoCreateTopics
{
    use ErrorHandler;

    public function createGitHubTopics($topics, $repository)
    {

        try {

            foreach ($topics as $topic) {
                if (strlen($topic) > 3) {
                    $tagtitle = ucfirst($topic);
                } else {
                    $tagtitle = strtoupper($topic);
                }

                $tag = RepositoryTag::firstOrCreate(['slug' => $topic],
                    [
                        'title' => $tagtitle,
                        'slug' => $topic,
                    ]);

                $repository->repositoryTags()->syncWithoutDetaching($tag);
            }

        } catch (\Exception $e) {

            $this->handleError('GitHub Topics', $e);

            return null;
        }
    }
}
