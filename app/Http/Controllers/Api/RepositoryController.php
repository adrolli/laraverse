<?php

namespace App\Http\Controllers\Api;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryResource;
use App\Http\Resources\RepositoryCollection;
use App\Http\Requests\RepositoryStoreRequest;
use App\Http\Requests\RepositoryUpdateRequest;

class RepositoryController extends Controller
{
    public function index(Request $request): RepositoryCollection
    {
        $this->authorize('view-any', Repository::class);

        $search = $request->get('search', '');

        $repositories = Repository::search($search)
            ->latest()
            ->paginate();

        return new RepositoryCollection($repositories);
    }

    public function store(RepositoryStoreRequest $request): RepositoryResource
    {
        $this->authorize('create', Repository::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $validated['composer'] = json_decode($validated['composer'], true);

        $validated['npm'] = json_decode($validated['npm'], true);

        $validated['code_analyzer'] = json_decode(
            $validated['code_analyzer'],
            true
        );

        $repository = Repository::create($validated);

        return new RepositoryResource($repository);
    }

    public function show(
        Request $request,
        Repository $repository
    ): RepositoryResource {
        $this->authorize('view', $repository);

        return new RepositoryResource($repository);
    }

    public function update(
        RepositoryUpdateRequest $request,
        Repository $repository
    ): RepositoryResource {
        $this->authorize('update', $repository);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $validated['composer'] = json_decode($validated['composer'], true);

        $validated['npm'] = json_decode($validated['npm'], true);

        $validated['code_analyzer'] = json_decode(
            $validated['code_analyzer'],
            true
        );

        $repository->update($validated);

        return new RepositoryResource($repository);
    }

    public function destroy(Request $request, Repository $repository): Response
    {
        $this->authorize('delete', $repository);

        $repository->delete();

        return response()->noContent();
    }
}
