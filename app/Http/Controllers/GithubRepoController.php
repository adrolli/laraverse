<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\GithubRepo;
use App\Models\GithubOwner;
use Illuminate\Http\Request;
use App\Models\GithubOrganization;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GithubRepoStoreRequest;
use App\Http\Requests\GithubRepoUpdateRequest;

class GithubRepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', GithubRepo::class);

        $search = $request->get('search', '');

        $githubRepos = GithubRepo::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.github_repos.index', compact('githubRepos', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', GithubRepo::class);

        $githubOrganizations = GithubOrganization::pluck('title', 'id');
        $githubOwners = GithubOwner::pluck('title', 'id');

        return view(
            'app.github_repos.create',
            compact('githubOrganizations', 'githubOwners')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GithubRepoStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', GithubRepo::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubRepo = GithubRepo::create($validated);

        return redirect()
            ->route('github-repos.edit', $githubRepo)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, GithubRepo $githubRepo): View
    {
        $this->authorize('view', $githubRepo);

        return view('app.github_repos.show', compact('githubRepo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, GithubRepo $githubRepo): View
    {
        $this->authorize('update', $githubRepo);

        $githubOrganizations = GithubOrganization::pluck('title', 'id');
        $githubOwners = GithubOwner::pluck('title', 'id');

        return view(
            'app.github_repos.edit',
            compact('githubRepo', 'githubOrganizations', 'githubOwners')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GithubRepoUpdateRequest $request,
        GithubRepo $githubRepo
    ): RedirectResponse {
        $this->authorize('update', $githubRepo);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubRepo->update($validated);

        return redirect()
            ->route('github-repos.edit', $githubRepo)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        GithubRepo $githubRepo
    ): RedirectResponse {
        $this->authorize('delete', $githubRepo);

        $githubRepo->delete();

        return redirect()
            ->route('github-repos.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
