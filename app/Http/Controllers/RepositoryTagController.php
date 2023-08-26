<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\RepositoryTag;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RepositoryTagStoreRequest;
use App\Http\Requests\RepositoryTagUpdateRequest;

class RepositoryTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', RepositoryTag::class);

        $search = $request->get('search', '');

        $repositoryTags = RepositoryTag::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.repository_tags.index',
            compact('repositoryTags', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', RepositoryTag::class);

        return view('app.repository_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepositoryTagStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', RepositoryTag::class);

        $validated = $request->validated();

        $repositoryTag = RepositoryTag::create($validated);

        return redirect()
            ->route('repository-tags.edit', $repositoryTag)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, RepositoryTag $repositoryTag): View
    {
        $this->authorize('view', $repositoryTag);

        return view('app.repository_tags.show', compact('repositoryTag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, RepositoryTag $repositoryTag): View
    {
        $this->authorize('update', $repositoryTag);

        return view('app.repository_tags.edit', compact('repositoryTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        RepositoryTagUpdateRequest $request,
        RepositoryTag $repositoryTag
    ): RedirectResponse {
        $this->authorize('update', $repositoryTag);

        $validated = $request->validated();

        $repositoryTag->update($validated);

        return redirect()
            ->route('repository-tags.edit', $repositoryTag)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        RepositoryTag $repositoryTag
    ): RedirectResponse {
        $this->authorize('delete', $repositoryTag);

        $repositoryTag->delete();

        return redirect()
            ->route('repository-tags.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
