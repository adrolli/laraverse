<?php

namespace App\Http\Controllers;

use App\Models\GithubTag;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GithubTagStoreRequest;
use App\Http\Requests\GithubTagUpdateRequest;

class GithubTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', GithubTag::class);

        $search = $request->get('search', '');

        $githubTags = GithubTag::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.github_tags.index', compact('githubTags', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', GithubTag::class);

        return view('app.github_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GithubTagStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', GithubTag::class);

        $validated = $request->validated();

        $githubTag = GithubTag::create($validated);

        return redirect()
            ->route('github-tags.edit', $githubTag)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, GithubTag $githubTag): View
    {
        $this->authorize('view', $githubTag);

        return view('app.github_tags.show', compact('githubTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, GithubTag $githubTag): View
    {
        $this->authorize('update', $githubTag);

        return view('app.github_tags.edit', compact('githubTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        GithubTagUpdateRequest $request,
        GithubTag $githubTag
    ): RedirectResponse {
        $this->authorize('update', $githubTag);

        $validated = $request->validated();

        $githubTag->update($validated);

        return redirect()
            ->route('github-tags.edit', $githubTag)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        GithubTag $githubTag
    ): RedirectResponse {
        $this->authorize('delete', $githubTag);

        $githubTag->delete();

        return redirect()
            ->route('github-tags.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
