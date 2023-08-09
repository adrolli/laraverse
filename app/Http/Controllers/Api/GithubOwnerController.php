<?php

namespace App\Http\Controllers\Api;

use App\Models\GithubOwner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubOwnerResource;
use App\Http\Resources\GithubOwnerCollection;
use App\Http\Requests\GithubOwnerStoreRequest;
use App\Http\Requests\GithubOwnerUpdateRequest;

class GithubOwnerController extends Controller
{
    public function index(Request $request): GithubOwnerCollection
    {
        $this->authorize('view-any', GithubOwner::class);

        $search = $request->get('search', '');

        $githubOwners = GithubOwner::search($search)
            ->latest()
            ->paginate();

        return new GithubOwnerCollection($githubOwners);
    }

    public function store(GithubOwnerStoreRequest $request): GithubOwnerResource
    {
        $this->authorize('create', GithubOwner::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOwner = GithubOwner::create($validated);

        return new GithubOwnerResource($githubOwner);
    }

    public function show(
        Request $request,
        GithubOwner $githubOwner
    ): GithubOwnerResource {
        $this->authorize('view', $githubOwner);

        return new GithubOwnerResource($githubOwner);
    }

    public function update(
        GithubOwnerUpdateRequest $request,
        GithubOwner $githubOwner
    ): GithubOwnerResource {
        $this->authorize('update', $githubOwner);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $githubOwner->update($validated);

        return new GithubOwnerResource($githubOwner);
    }

    public function destroy(
        Request $request,
        GithubOwner $githubOwner
    ): Response {
        $this->authorize('delete', $githubOwner);

        $githubOwner->delete();

        return response()->noContent();
    }
}
