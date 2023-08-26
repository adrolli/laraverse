<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;

class OrganizationController extends Controller
{
    public function index(Request $request): OrganizationCollection
    {
        $this->authorize('view-any', Organization::class);

        $search = $request->get('search', '');

        $organizations = Organization::search($search)
            ->latest()
            ->paginate();

        return new OrganizationCollection($organizations);
    }

    public function store(
        OrganizationStoreRequest $request
    ): OrganizationResource {
        $this->authorize('create', Organization::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $organization = Organization::create($validated);

        return new OrganizationResource($organization);
    }

    public function show(
        Request $request,
        Organization $organization
    ): OrganizationResource {
        $this->authorize('view', $organization);

        return new OrganizationResource($organization);
    }

    public function update(
        OrganizationUpdateRequest $request,
        Organization $organization
    ): OrganizationResource {
        $this->authorize('update', $organization);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $organization->update($validated);

        return new OrganizationResource($organization);
    }

    public function destroy(
        Request $request,
        Organization $organization
    ): Response {
        $this->authorize('delete', $organization);

        $organization->delete();

        return response()->noContent();
    }
}
