<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\GithubOwner;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GithubOwnerStoreRequest;
use App\Http\Requests\GithubOwnerUpdateRequest;

class GithubOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', GithubOwner::class);

        $search = $request->get('search', '');

        $githubOwners = GithubOwner::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.github_owners.index',
            compact('githubOwners', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', GithubOwner::class);

        return view('app.github_owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GithubOwnerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', GithubOwner::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOwner = GithubOwner::create($validated);

        return redirect()
            ->route('github-owners.edit', $githubOwner)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, GithubOwner $githubOwner): View
    {
        $this->authorize('view', $githubOwner);

        return view('app.github_owners.show', compact('githubOwner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, GithubOwner $githubOwner): View
    {
        $this->authorize('update', $githubOwner);

        return view('app.github_owners.edit', compact('githubOwner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GithubOwnerUpdateRequest $request,
        GithubOwner $githubOwner
    ): RedirectResponse {
        $this->authorize('update', $githubOwner);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $githubOwner->update($validated);

        return redirect()
            ->route('github-owners.edit', $githubOwner)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        GithubOwner $githubOwner
    ): RedirectResponse {
        $this->authorize('delete', $githubOwner);

        $githubOwner->delete();

        return redirect()
            ->route('github-owners.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
