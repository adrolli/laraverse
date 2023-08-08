<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PlatformStoreRequest;
use App\Http\Requests\PlatformUpdateRequest;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Platform::class);

        $search = $request->get('search', '');

        $platforms = Platform::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.platforms.index', compact('platforms', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Platform::class);

        return view('app.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlatformStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Platform::class);

        $validated = $request->validated();

        $platform = Platform::create($validated);

        return redirect()
            ->route('platforms.edit', $platform)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Platform $platform): View
    {
        $this->authorize('view', $platform);

        return view('app.platforms.show', compact('platform'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Platform $platform): View
    {
        $this->authorize('update', $platform);

        return view('app.platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PlatformUpdateRequest $request,
        Platform $platform
    ): RedirectResponse {
        $this->authorize('update', $platform);

        $validated = $request->validated();

        $platform->update($validated);

        return redirect()
            ->route('platforms.edit', $platform)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Platform $platform
    ): RedirectResponse {
        $this->authorize('delete', $platform);

        $platform->delete();

        return redirect()
            ->route('platforms.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
