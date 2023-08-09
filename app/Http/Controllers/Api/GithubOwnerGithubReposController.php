<?php

namespace App\Http\Controllers\Api;

use App\Models\GithubOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubRepoResource;
use App\Http\Resources\GithubRepoCollection;

class GithubOwnerGithubReposController extends Controller
{
    public function index(
        Request $request,
        GithubOwner $githubOwner
    ): GithubRepoCollection {
        $this->authorize('view', $githubOwner);

        $search = $request->get('search', '');

        $githubRepos = $githubOwner
            ->githubRepos()
            ->search($search)
            ->latest()
            ->paginate();

        return new GithubRepoCollection($githubRepos);
    }

    public function store(
        Request $request,
        GithubOwner $githubOwner
    ): GithubRepoResource {
        $this->authorize('create', GithubRepo::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'github_organization_id' => [
                'required',
                'exists:github_organizations,id',
            ],
        ]);

        $githubRepo = $githubOwner->githubRepos()->create($validated);

        return new GithubRepoResource($githubRepo);
    }
}
