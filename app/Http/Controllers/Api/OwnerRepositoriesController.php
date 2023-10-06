<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryCollection;
use App\Http\Resources\RepositoryResource;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerRepositoriesController extends Controller
{
    public function index(Request $request, Owner $owner): RepositoryCollection
    {
        $this->authorize('view', $owner);

        $search = $request->get('search', '');

        $repositories = $owner
            ->repositories()
            ->search($search)
            ->latest()
            ->paginate();

        return new RepositoryCollection($repositories);
    }

    public function store(Request $request, Owner $owner): RepositoryResource
    {
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
            'repository_type_id' => ['required', 'exists:repository_types,id'],
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);

        $repository = $owner->repositories()->create($validated);

        return new RepositoryResource($repository);
    }
}
