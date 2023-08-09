<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GithubOrganization;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubRepoResource;
use App\Http\Resources\GithubRepoCollection;

class GithubOrganizationGithubReposController extends Controller
{
    public function index(
        Request $request,
        GithubOrganization $githubOrganization
    ): GithubRepoCollection {
        $this->authorize('view', $githubOrganization);

        $search = $request->get('search', '');

        $githubRepos = $githubOrganization
            ->githubRepos()
            ->search($search)
            ->latest()
            ->paginate();

        return new GithubRepoCollection($githubRepos);
    }

    public function store(
        Request $request,
        GithubOrganization $githubOrganization
    ): GithubRepoResource {
        $this->authorize('create', GithubRepo::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'github_owner_id' => ['required', 'exists:github_owners,id'],
        ]);

        $githubRepo = $githubOrganization->githubRepos()->create($validated);

        return new GithubRepoResource($githubRepo);
    }
}
