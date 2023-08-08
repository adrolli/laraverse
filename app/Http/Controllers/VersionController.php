<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Version;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\VersionStoreRequest;
use App\Http\Requests\VersionUpdateRequest;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Version::class);

        $search = $request->get('search', '');

        $versions = Version::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.versions.index', compact('versions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Version::class);

        $items = Item::pluck('title', 'id');

        return view('app.versions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VersionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Version::class);

        $validated = $request->validated();

        $version = Version::create($validated);

        return redirect()
            ->route('versions.edit', $version)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Version $version): View
    {
        $this->authorize('view', $version);

        return view('app.versions.show', compact('version'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Version $version): View
    {
        $this->authorize('update', $version);

        $items = Item::pluck('title', 'id');

        return view('app.versions.edit', compact('version', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        VersionUpdateRequest $request,
        Version $version
    ): RedirectResponse {
        $this->authorize('update', $version);

        $validated = $request->validated();

        $version->update($validated);

        return redirect()
            ->route('versions.edit', $version)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Version $version
    ): RedirectResponse {
        $this->authorize('delete', $version);

        $version->delete();

        return redirect()
            ->route('versions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
