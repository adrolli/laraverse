<?php

namespace App\Http\Controllers\Api;

use App\Models\GithubRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubRepoResource;
use App\Http\Resources\GithubRepoCollection;
use App\Http\Requests\GithubRepoStoreRequest;
use App\Http\Requests\GithubRepoUpdateRequest;

class GithubRepoController extends Controller
{
    public function index(Request $request): GithubRepoCollection
    {
        $this->authorize('view-any', GithubRepo::class);

        $search = $request->get('search', '');

        $githubRepos = GithubRepo::search($search)
            ->latest()
            ->paginate();

        return new GithubRepoCollection($githubRepos);
    }

    public function store(GithubRepoStoreRequest $request): GithubRepoResource
    {
        $this->authorize('create', GithubRepo::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubRepo = GithubRepo::create($validated);

        return new GithubRepoResource($githubRepo);
    }

    public function show(
        Request $request,
        GithubRepo $githubRepo
    ): GithubRepoResource {
        $this->authorize('view', $githubRepo);

        return new GithubRepoResource($githubRepo);
    }

    public function update(
        GithubRepoUpdateRequest $request,
        GithubRepo $githubRepo
    ): GithubRepoResource {
        $this->authorize('update', $githubRepo);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $githubRepo->update($validated);

        return new GithubRepoResource($githubRepo);
    }

    public function destroy(Request $request, GithubRepo $githubRepo): Response
    {
        $this->authorize('delete', $githubRepo);

        $githubRepo->delete();

        return response()->noContent();
    }
}
