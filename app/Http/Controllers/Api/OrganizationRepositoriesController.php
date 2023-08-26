<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryResource;
use App\Http\Resources\RepositoryCollection;

class OrganizationRepositoriesController extends Controller
{
    public function index(
        Request $request,
        Organization $organization
    ): RepositoryCollection {
        $this->authorize('view', $organization);

        $search = $request->get('search', '');

        $repositories = $organization
            ->repositories()
            ->search($search)
            ->latest()
            ->paginate();

        return new RepositoryCollection($repositories);
    }

    public function store(
        Request $request,
        Organization $organization
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
            'package_type' => ['required', 'max:255', 'string'],
            'repository_type_id' => ['required', 'exists:repository_types,id'],
            'owner_id' => ['required', 'exists:owners,id'],
        ]);

        $repository = $organization->repositories()->create($validated);

        return new RepositoryResource($repository);
    }
}
