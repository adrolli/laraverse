<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;

trait RepoCreateContents
{
    use ErrorHandler, GetChangelog, GetComposerJson, GetContents, GetLicense, GetPackageJson, GetReadme;

    public function createGitHubContents($createRepo)
    {

        try {

            $repositoryContents = $this->getGitHubContents($createRepo['slug']);

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

            $result = [
                'createRepo' => $createRepo,
                'repositoryContents' => $repositoryContents,
            ];

            return $result;

        } catch (\Exception $e) {

            $this->handleError('GitHub Contents', $e);

            return null;
        }
    }
}
