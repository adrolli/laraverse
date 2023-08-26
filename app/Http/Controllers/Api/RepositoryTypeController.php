<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RepositoryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryTypeResource;
use App\Http\Resources\RepositoryTypeCollection;
use App\Http\Requests\RepositoryTypeStoreRequest;
use App\Http\Requests\RepositoryTypeUpdateRequest;

class RepositoryTypeController extends Controller
{
    public function index(Request $request): RepositoryTypeCollection
    {
        $this->authorize('view-any', RepositoryType::class);

        $search = $request->get('search', '');

        $repositoryTypes = RepositoryType::search($search)
            ->latest()
            ->paginate();

        return new RepositoryTypeCollection($repositoryTypes);
    }

    public function store(
        RepositoryTypeStoreRequest $request
    ): RepositoryTypeResource {
        $this->authorize('create', RepositoryType::class);

        $validated = $request->validated();

        $repositoryType = RepositoryType::create($validated);

        return new RepositoryTypeResource($repositoryType);
    }

    public function show(
        Request $request,
        RepositoryType $repositoryType
    ): RepositoryTypeResource {
        $this->authorize('view', $repositoryType);

        return new RepositoryTypeResource($repositoryType);
    }

    public function update(
        RepositoryTypeUpdateRequest $request,
        RepositoryType $repositoryType
    ): RepositoryTypeResource {
        $this->authorize('update', $repositoryType);

        $validated = $request->validated();

        $repositoryType->update($validated);

        return new RepositoryTypeResource($repositoryType);
    }

    public function destroy(
        Request $request,
        RepositoryType $repositoryType
    ): Response {
        $this->authorize('delete', $repositoryType);

        $repositoryType->delete();

        return response()->noContent();
    }
}
