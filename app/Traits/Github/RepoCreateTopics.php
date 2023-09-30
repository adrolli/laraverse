<?php

namespace App\Traits\Github;

use App\Models\RepositoryTag;

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

            $this->handleApiError($e, 'GitHub Topics');

            return null;
        }
    }
}
