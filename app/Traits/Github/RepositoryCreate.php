<?php

namespace App\Traits\Github;

use App\Models\Repository;

trait RepositoryCreate
{
    use RepoCreateContents, RepoCreateOwner, RepoCreateSource, RepoCreateTopics, RepoCreateType;

    public function createGitHubRepository($repositoryData, $repositorySource)
    {
        $createRepo['slug'] = $repositoryData['full_name'];

        try {

            $createRepo['ghid'] = $repositoryData['id'];
            $createRepo['title'] = $repositoryData['name'];
            $createRepo['description'] = $repositoryData['description'];
            $createRepo['homepage'] = $repositoryData['homepage'];
            $createRepo['private'] = $repositoryData['private'];
            $createRepo['fork'] = $repositoryData['fork'];
            $createRepo['archived'] = $repositoryData['archived'];
            $createRepo['disabled'] = $repositoryData['disabled'];
            $createRepo['template'] = $repositoryData['is_template'];
            $createRepo['data'] = $repositoryData;
            $license = $repositoryData['license'];

            if ($license != null) {
                $createRepo['license'] = $license['key'];
            }

            $createGitHubContents = $this->createGitHubContents($createRepo);
            $createRepo = $createGitHubContents['createRepo'];

            $repositoryContents = $createGitHubContents['repositoryContents'];
            $type = $this->createGitHubType($repositoryContents, $createRepo);
            $source = $this->createGitHubSource($repositorySource);

            $repository = Repository::updateOrCreate(
                ['slug' => $createRepo['slug']],
                $createRepo
            );

            if ($type) {
                $repository->repositoryType()->associate($type);
            }

            if ($source) {
                $repository->repositorySource()->associate($source);
            }

            $owner = $repositoryData['owner'];

            if ($owner) {
                $this->createGitHubOwner($repository, $owner);
            }

            $topics = $repositoryData['topics'];

            if ($topics) {
                $this->createGitHubTopics($topics, $repository);
            }

            $repository->save();

            activity()->log("GitHub repo {$createRepo['slug']} created");

        } catch (\Exception $e) {

            if ($createRepo['slug']) {
                activity()->log("GitHub repo {$createRepo['slug']} create failed: ".$e);
            } else {
                activity()->log('GitHub repo (unknown slug) create failed: '.$e);

            }

            return null;
        }
    }
}
