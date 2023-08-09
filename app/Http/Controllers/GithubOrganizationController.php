<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\GithubOrganization;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GithubOrganizationStoreRequest;
use App\Http\Requests\GithubOrganizationUpdateRequest;

class GithubOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', GithubOrganization::class);

        $search = $request->get('search', '');

        $githubOrganizations = GithubOrganization::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.github_organizations.index',
            compact('githubOrganizations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', GithubOrganization::class);

        return view('app.github_organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        GithubOrganizationStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', GithubOrganization::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOrganization = GithubOrganization::create($validated);

        return redirect()
            ->route('github-organizations.edit', $githubOrganization)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        GithubOrganization $githubOrganization
    ): View {
        $this->authorize('view', $githubOrganization);

        return view(
            'app.github_organizations.show',
            compact('githubOrganization')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        GithubOrganization $githubOrganization
    ): View {
        $this->authorize('update', $githubOrganization);

        return view(
            'app.github_organizations.edit',
            compact('githubOrganization')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GithubOrganizationUpdateRequest $request,
        GithubOrganization $githubOrganization
    ): RedirectResponse {
        $this->authorize('update', $githubOrganization);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOrganization->update($validated);

        return redirect()
            ->route('github-organizations.edit', $githubOrganization)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        GithubOrganization $githubOrganization
    ): RedirectResponse {
        $this->authorize('delete', $githubOrganization);

        $githubOrganization->delete();

        return redirect()
            ->route('github-organizations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
