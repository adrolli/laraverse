<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryCollection;
use App\Http\Resources\RepositoryResource;
use App\Models\RepositoryType;
use Illuminate\Http\Request;

class RepositoryTypeRepositoriesController extends Controller
{
    public function index(
        Request $request,
        RepositoryType $repositoryType
    ): RepositoryCollection {
        $this->authorize('view', $repositoryType);

        $search = $request->get('search', '');

        $repositories = $repositoryType
            ->repositories()
            ->search($search)
            ->latest()
            ->paginate();

        return new RepositoryCollection($repositories);
    }

    public function store(
        Request $request,
        RepositoryType $repositoryType
    ): RepositoryResource {
        $this->authorize('create', Repository::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'license' => ['required', 'max:255', 'string'],
            'readme' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'composer' => ['required', 'max:255', 'json'],
            'npm' => ['required', 'max:255', 'json'],
            'code_analyzer' => ['required', 'max:255', 'json'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'owner_id' => ['required', 'exists:owners,id'],
        ]);

        $repository = $repositoryType->repositories()->create($validated);

        return new RepositoryResource($repository);
    }
}
