<?php

namespace App\Traits\Github;

use App\Models\Organization;
use App\Models\Owner;
use App\Traits\ErrorHandler;

trait RepoCreateOwner
{
    use ErrorHandler, GetOwner;

    public function createGitHubOwner($repository, $owner)
    {

        try {

            $createOwner['ghid'] = $owner['id'];
            $createOwner['title'] = $owner['login'];
            $createOwner['slug'] = $owner['login'];
            $createOwner['type'] = $owner['type'];
            $createOwner['url'] = $owner['html_url'];
            $createOwner['avatar'] = $owner['avatar_url'];
            $createOwner['gravatar'] = $owner['gravatar_id'];
            $ownerApiUrl = $owner['url'];
            $createOwner['data'] = $this->getGitHubOwner($ownerApiUrl);

            if ($createOwner['type'] == 'Organization') {
                $organization = Organization::updateOrCreate(['slug' => $createOwner['slug']], $createOwner);
                $repository->organization()->associate($organization);
            } else {
                $owner = Owner::updateOrCreate(['slug' => $createOwner['slug']], $createOwner);
                $repository->owner()->associate($owner);
            }

        } catch (\Exception $e) {

            $this->handleError('GitHub Owner', $e);

            return null;
        }
    }
}
