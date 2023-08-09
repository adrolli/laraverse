<?php

namespace App\Http\Controllers\Api;

use App\Models\GithubTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubTagResource;
use App\Http\Resources\GithubTagCollection;
use App\Http\Requests\GithubTagStoreRequest;
use App\Http\Requests\GithubTagUpdateRequest;

class GithubTagController extends Controller
{
    public function index(Request $request): GithubTagCollection
    {
        $this->authorize('view-any', GithubTag::class);

        $search = $request->get('search', '');

        $githubTags = GithubTag::search($search)
            ->latest()
            ->paginate();

        return new GithubTagCollection($githubTags);
    }

    public function store(GithubTagStoreRequest $request): GithubTagResource
    {
        $this->authorize('create', GithubTag::class);

        $validated = $request->validated();

        $githubTag = GithubTag::create($validated);

        return new GithubTagResource($githubTag);
    }

    public function show(
        Request $request,
        GithubTag $githubTag
    ): GithubTagResource {
        $this->authorize('view', $githubTag);

        return new GithubTagResource($githubTag);
    }

    public function update(
        GithubTagUpdateRequest $request,
        GithubTag $githubTag
    ): GithubTagResource {
        $this->authorize('update', $githubTag);

        $validated = $request->validated();

        $githubTag->update($validated);

        return new GithubTagResource($githubTag);
    }

    public function destroy(Request $request, GithubTag $githubTag): Response
    {
        $this->authorize('delete', $githubTag);

        $githubTag->delete();

        return response()->noContent();
    }
}
