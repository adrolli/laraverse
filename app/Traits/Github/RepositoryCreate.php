<?php

namespace App\Traits\Github;

use App\Models\Organization;
use App\Models\Owner;
use App\Models\Repository;
use App\Models\RepositoryTag;
use App\Models\RepositoryType;

trait RepositoryCreate
{
    use GetOwner;

    public function createGitHubRepository($slug)
    {
        $repositoryData = $this->getGitHubRepository($slug);
        $repositoryContents = $this->getGitHubContents($slug);

        $createRepo['ghid'] = $repositoryData['id'];
        $createRepo['slug'] = $repositoryData['full_name'];

        try {
            $createRepo['title'] = $repositoryData['name'];
            $createRepo['description'] = $repositoryData['description'];
            $createRepo['homepage'] = $repositoryData['homepage'];

            $owner = $repositoryData['owner'];
            $createOwner['ghid'] = $owner['id'];
            $createOwner['title'] = $owner['login'];
            $createOwner['slug'] = $owner['login'];
            $createOwner['type'] = $owner['type'];
            $createOwner['url'] = $owner['html_url'];
            $createOwner['avatar'] = $owner['avatar_url'];
            $createOwner['gravatar'] = $owner['gravatar_id'];
            $ownerApiUrl = $owner['url'];
            $createOwner['data'] = $this->getGitHubOwner($ownerApiUrl);

            $license = $repositoryData['license'];
            if ($license != null) {
                $createRepo['license'] = $license['key'];
            }

            $createRepo['private'] = $repositoryData['private'];
            $createRepo['fork'] = $repositoryData['fork'];
            $createRepo['archived'] = $repositoryData['archived'];
            $createRepo['disabled'] = $repositoryData['disabled'];
            $createRepo['template'] = $repositoryData['is_template'];

            if ($repositoryContents['database'] != false) {
                $createRepo['database'] = true;
            } else {
                $createRepo['database'] = false;

            }

            if ($repositoryContents['resources'] != false) {
                $createRepo['resources'] = true;
            } else {
                $createRepo['resources'] = false;

            }

            if ($repositoryContents['public'] != false) {
                $createRepo['public'] = true;
            } else {
                $createRepo['public'] = false;

            }

            if ($repositoryContents['routes'] != false) {
                $createRepo['routes'] = true;
            } else {
                $createRepo['routes'] = false;

            }

            if ($repositoryContents['tests'] != false) {
                $createRepo['tests'] = true;
            } else {
                $createRepo['tests'] = false;

            }

            if ($repositoryContents['vite.config.js'] != false) {
                $createRepo['vite'] = true;
            } else {
                $createRepo['vite'] = false;

            }

            if ($repositoryContents['tailwind.config.js'] != false) {
                $createRepo['tailwind'] = true;
            } else {
                $createRepo['tailwind'] = false;

            }

            if ($repositoryContents['docker-compose.yml'] != false) {
                $createRepo['docker'] = true;
            } else {
                $createRepo['docker'] = false;

            }

            if ($repositoryContents['README.md'] != false) {
                $createRepo['readme'] = $this->getGitHubReadme($repositoryContents['README.md']);
            }

            if ($repositoryContents['CHANGELOG.md'] != false) {
                $createRepo['changelog'] = $this->getGitHubChangelog($repositoryContents['CHANGELOG.md']);
            }

            if ($repositoryContents['composer.json'] != false) {
                $composer = $this->getGitHubComposerJson($repositoryContents['composer.json']);
                $createRepo['composer'] = json_decode($composer);
            }

            if ($repositoryContents['package.json'] != false) {
                $npm = $this->getGitHubPackageJson($repositoryContents['package.json']);
                $createRepo['npm'] = json_decode($npm);
            }

            if ($repositoryContents['LICENSE.md'] != false) {
                $createRepo['licensefile'] = $this->getGitHubLicense($repositoryContents['LICENSE.md']);
            }

            $createRepo['data'] = $repositoryData;

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

            $repository = Repository::updateOrCreate(
                ['slug' => $createRepo['slug']],
                $createRepo
            );

            $repository->repositoryType()->associate($type);

            if ($owner) {
                if ($createOwner['type'] == 'Organization') {
                    $organization = Organization::updateOrCreate(['slug' => $createOwner['slug']], $createOwner);
                    $repository->organization()->associate($organization);
                } else {
                    $owner = Owner::updateOrCreate(['slug' => $createOwner['slug']], $createOwner);
                    $repository->owner()->associate($owner);
                }
            }

            $topics = $repositoryData['topics'];

            if ($topics) {
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
