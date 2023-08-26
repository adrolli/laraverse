<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RepositoryTag;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryTagResource;
use App\Http\Resources\RepositoryTagCollection;
use App\Http\Requests\RepositoryTagStoreRequest;
use App\Http\Requests\RepositoryTagUpdateRequest;

class RepositoryTagController extends Controller
{
    public function index(Request $request): RepositoryTagCollection
    {
        $this->authorize('view-any', RepositoryTag::class);

        $search = $request->get('search', '');

        $repositoryTags = RepositoryTag::search($search)
            ->latest()
            ->paginate();

        return new RepositoryTagCollection($repositoryTags);
    }

    public function store(
        RepositoryTagStoreRequest $request
    ): RepositoryTagResource {
        $this->authorize('create', RepositoryTag::class);

        $validated = $request->validated();

        $repositoryTag = RepositoryTag::create($validated);

        return new RepositoryTagResource($repositoryTag);
    }

    public function show(
        Request $request,
        RepositoryTag $repositoryTag
    ): RepositoryTagResource {
        $this->authorize('view', $repositoryTag);

        return new RepositoryTagResource($repositoryTag);
    }

    public function update(
        RepositoryTagUpdateRequest $request,
        RepositoryTag $repositoryTag
    ): RepositoryTagResource {
        $this->authorize('update', $repositoryTag);

        $validated = $request->validated();

        $repositoryTag->update($validated);

        return new RepositoryTagResource($repositoryTag);
    }

    public function destroy(
        Request $request,
        RepositoryTag $repositoryTag
    ): Response {
        $this->authorize('delete', $repositoryTag);

        $repositoryTag->delete();

        return response()->noContent();
    }
}
