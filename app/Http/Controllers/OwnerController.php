<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OwnerStoreRequest;
use App\Http\Requests\OwnerUpdateRequest;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Owner::class);

        $search = $request->get('search', '');

        $owners = Owner::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.owners.index', compact('owners', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Owner::class);

        return view('app.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Owner::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $owner = Owner::create($validated);

        return redirect()
            ->route('owners.edit', $owner)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Owner $owner): View
    {
        $this->authorize('view', $owner);

        return view('app.owners.show', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Owner $owner): View
    {
        $this->authorize('update', $owner);

        return view('app.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        OwnerUpdateRequest $request,
        Owner $owner
    ): RedirectResponse {
        $this->authorize('update', $owner);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $owner->update($validated);

        return redirect()
            ->route('owners.edit', $owner)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Owner $owner): RedirectResponse
    {
        $this->authorize('delete', $owner);

        $owner->delete();

        return redirect()
            ->route('owners.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
