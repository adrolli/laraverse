<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\NpmPackage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\NpmPackageStoreRequest;
use App\Http\Requests\NpmPackageUpdateRequest;

class NpmPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', NpmPackage::class);

        $search = $request->get('search', '');

        $npmPackages = NpmPackage::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.npm_packages.index', compact('npmPackages', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', NpmPackage::class);

        return view('app.npm_packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NpmPackageStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', NpmPackage::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $npmPackage = NpmPackage::create($validated);

        return redirect()
            ->route('npm-packages.edit', $npmPackage)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, NpmPackage $npmPackage): View
    {
        $this->authorize('view', $npmPackage);

        return view('app.npm_packages.show', compact('npmPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, NpmPackage $npmPackage): View
    {
        $this->authorize('update', $npmPackage);

        return view('app.npm_packages.edit', compact('npmPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        NpmPackageUpdateRequest $request,
        NpmPackage $npmPackage
    ): RedirectResponse {
        $this->authorize('update', $npmPackage);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $npmPackage->update($validated);

        return redirect()
            ->route('npm-packages.edit', $npmPackage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        NpmPackage $npmPackage
    ): RedirectResponse {
        $this->authorize('delete', $npmPackage);

        $npmPackage->delete();

        return redirect()
            ->route('npm-packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
