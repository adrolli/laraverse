<?php

namespace App\Http\Controllers\Api;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostTypeResource;
use App\Http\Resources\PostTypeCollection;
use App\Http\Requests\PostTypeStoreRequest;
use App\Http\Requests\PostTypeUpdateRequest;

class PostTypeController extends Controller
{
    public function index(Request $request): PostTypeCollection
    {
        $this->authorize('view-any', PostType::class);

        $search = $request->get('search', '');

        $postTypes = PostType::search($search)
            ->latest()
            ->paginate();

        return new PostTypeCollection($postTypes);
    }

    public function store(PostTypeStoreRequest $request): PostTypeResource
    {
        $this->authorize('create', PostType::class);

        $validated = $request->validated();

        $postType = PostType::create($validated);

        return new PostTypeResource($postType);
    }

    public function show(Request $request, PostType $postType): PostTypeResource
    {
        $this->authorize('view', $postType);

        return new PostTypeResource($postType);
    }

    public function update(
        PostTypeUpdateRequest $request,
        PostType $postType
    ): PostTypeResource {
        $this->authorize('update', $postType);

        $validated = $request->validated();

        $postType->update($validated);

        return new PostTypeResource($postType);
    }

    public function destroy(Request $request, PostType $postType): Response
    {
        $this->authorize('delete', $postType);

        $postType->delete();

        return response()->noContent();
    }
}
