<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GithubOrganization;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubOrganizationResource;
use App\Http\Resources\GithubOrganizationCollection;
use App\Http\Requests\GithubOrganizationStoreRequest;
use App\Http\Requests\GithubOrganizationUpdateRequest;

class GithubOrganizationController extends Controller
{
    public function index(Request $request): GithubOrganizationCollection
    {
        $this->authorize('view-any', GithubOrganization::class);

        $search = $request->get('search', '');

        $githubOrganizations = GithubOrganization::search($search)
            ->latest()
            ->paginate();

        return new GithubOrganizationCollection($githubOrganizations);
    }

    public function store(
        GithubOrganizationStoreRequest $request
    ): GithubOrganizationResource {
        $this->authorize('create', GithubOrganization::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOrganization = GithubOrganization::create($validated);

        return new GithubOrganizationResource($githubOrganization);
    }

    public function show(
        Request $request,
        GithubOrganization $githubOrganization
    ): GithubOrganizationResource {
        $this->authorize('view', $githubOrganization);

        return new GithubOrganizationResource($githubOrganization);
    }

    public function update(
        GithubOrganizationUpdateRequest $request,
        GithubOrganization $githubOrganization
    ): GithubOrganizationResource {
        $this->authorize('update', $githubOrganization);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $githubOrganization->update($validated);

        return new GithubOrganizationResource($githubOrganization);
    }

    public function destroy(
        Request $request,
        GithubOrganization $githubOrganization
    ): Response {
        $this->authorize('delete', $githubOrganization);

        $githubOrganization->delete();

        return response()->noContent();
    }
}
