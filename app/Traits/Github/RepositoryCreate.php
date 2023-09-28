<?php

namespace App\Traits\Github;

use App\Models\Organization;
use App\Models\Owner;
use App\Models\Repository;
use App\Models\RepositoryTag;

trait RepositoryCreate
{
    public function prepareGitHubRepository($repositoryData, $repositoryContents)
    {

        $ghid = $repositoryData['id'];
        $slug = $repositoryData['full_name'];

        try {
            $name = $repositoryData['name'];
            $description = $repositoryData['description'];
            $homepage = $repositoryData['homepage'];

            $owner = $repositoryData['owner'];
            $ownid = $owner['id'];
            $oname = $owner['login'];
            $otype = $owner['type'];
            $owurl = $owner['html_url'];
            $avatar = $owner['avatar_url'];
            $gravatar = $owner['gravatar_id'];

            $license = $repositoryData['license'];
            if ($license != null) {
                $lic_key = $license['key'];
                $licname = $license['name'];
                $spdx_id = $license['spdx_id'];
            }

            $private = $repositoryData['private'];
            $fork = $repositoryData['fork'];
            $archived = $repositoryData['archived'];
            $disabled = $repositoryData['disabled'];
            $template = $repositoryData['is_template'];

            if ($repositoryContents['artisan'] != false and $repositoryContents['app'] != false) {
                $type = 'App';
            } elseif ($template == 1) {
                $type = 'Template';
            } elseif ($repositoryContents['src'] != false and $repositoryContents['composer.json'] != false) {
                $type = 'Package';
            } else {
                $type = 'Unknown';
            }

            if ($repositoryContents['database'] != false) {
                $hasDatabase = true;
            }

            if ($repositoryContents['resources'] != false) {
                $hasResources = true;
            }

            if ($repositoryContents['public'] != false) {
                $hasPublic = true;
            }

            if ($repositoryContents['routes'] != false) {
                $hasRoutes = true;
            }

            if ($repositoryContents['tests'] != false) {
                $hasTests = true;
            }

            if ($repositoryContents['vite.config.js'] != false) {
                $hasVite = true;
            }

            if ($repositoryContents['tailwind.config.js'] != false) {
                $hasTailwind = true;
            }

            if ($repositoryContents['docker-compose.yml'] != false) {
                $hasDocker = true;
            }

            if ($repositoryContents['README.md'] != false) {
                $readmeMd = $this->getGitHubReadme($repositoryContents['README.md']);
            }

            if ($repositoryContents['CHANGELOG.md'] != false) {
                $changelogMd = $this->getGitHubChangelog($repositoryContents['CHANGELOG.md']);
            }

            if ($repositoryContents['composer.json'] != false) {
                $composerJson = $this->getGitHubComposerJson($repositoryContents['composer.json']);
            }

            if ($repositoryContents['package.json'] != false) {
                $packageJson = $this->getGitHubPackageJson($repositoryContents['package.json']);
            }

            if ($repositoryContents['LICENSE.md'] != false) {
                $licenseMd = $this->getGitHubLicense($repositoryContents['LICENSE.md']);
            }

            $repositoryCreateData = [
                'title' => 'My Repository',
                'slug' => 'my-repo',
                'description' => 'A sample repository',
                'license' => 'MIT',
                'readme' => 'readme',
                'data' => 'data',
                'composer' => 'data',
                'npm' => 'data',
                'code_analyzer' => 'data',
                'package_type' => 'data', // delete this?
            ];

            if ($otype = 'User') {
                //
            } elseif ($otype = 'Organization') {
                //
            }

            $ownerData = [
                'title' => 'John Doe',
                'slug' => 'john-doe',
                'data' => 'john-doe-avatar.jpg',
            ];

            $orgData = [
                'title' => 'My Organization',
                'slug' => 'my-org',
                'data' => 'org-avatar.jpg',
            ];

            $topics = $repositoryData['topics'];
            foreach ($topics as $topic) {
                $tag = RepositoryTag::firstOrCreate(['slug' => $topic],
                    [
                        'title' => ucfirst($topic),
                        'slug' => $topic,
                    ]);
            }

            // check type
            if ($owner) {
                $owner = Owner::firstOrCreate(['slug' => $ownerData['slug']], $ownerData);
                $org = Organization::firstOrCreate(['slug' => $orgData['slug']], $orgData);
            }

            // repository_type ???

            // finish with fields
            $repository = Repository::updateOrCreate(
                ['slug' => $slug],
                $repositoryCreateData
            );

            $repository->tag()->associate($tag);
            $repository->owner()->associate($owner);
            $repository->organisation()->associate($org);

            $tag->save();
            $owner->save();
            $org->save();
            $repository->save();

        } catch (\Exception $e) {

            if ($slug) {
                activity()->log("GitHub repo {$slug} create failed: ".$e);
            } else {
                activity()->log('GitHub repo (unknown slug) create failed: '.$e);

            }

            return null;
        }
    }
}
