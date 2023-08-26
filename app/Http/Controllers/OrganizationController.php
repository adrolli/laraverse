<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OrganizationStoreRequest;
use App\Http\Requests\OrganizationUpdateRequest;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Organization::class);

        $search = $request->get('search', '');

        $organizations = Organization::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.organizations.index',
            compact('organizations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Organization::class);

        return view('app.organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Organization::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $organization = Organization::create($validated);

        return redirect()
            ->route('organizations.edit', $organization)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Organization $organization): View
    {
        $this->authorize('view', $organization);

        return view('app.organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Organization $organization): View
    {
        $this->authorize('update', $organization);

        return view('app.organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        OrganizationUpdateRequest $request,
        Organization $organization
    ): RedirectResponse {
        $this->authorize('update', $organization);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $organization->update($validated);

        return redirect()
            ->route('organizations.edit', $organization)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Organization $organization
    ): RedirectResponse {
        $this->authorize('delete', $organization);

        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
