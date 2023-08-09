<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PackagistPackage;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PackagistPackageStoreRequest;
use App\Http\Requests\PackagistPackageUpdateRequest;

class PackagistPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PackagistPackage::class);

        $search = $request->get('search', '');

        $packagistPackages = PackagistPackage::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.packagist_packages.index',
            compact('packagistPackages', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PackagistPackage::class);

        return view('app.packagist_packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        PackagistPackageStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', PackagistPackage::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $packagistPackage = PackagistPackage::create($validated);

        return redirect()
            ->route('packagist-packages.edit', $packagistPackage)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        PackagistPackage $packagistPackage
    ): View {
        $this->authorize('view', $packagistPackage);

        return view('app.packagist_packages.show', compact('packagistPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        PackagistPackage $packagistPackage
    ): View {
        $this->authorize('update', $packagistPackage);

        return view('app.packagist_packages.edit', compact('packagistPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PackagistPackageUpdateRequest $request,
        PackagistPackage $packagistPackage
    ): RedirectResponse {
        $this->authorize('update', $packagistPackage);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $packagistPackage->update($validated);

        return redirect()
            ->route('packagist-packages.edit', $packagistPackage)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PackagistPackage $packagistPackage
    ): RedirectResponse {
        $this->authorize('delete', $packagistPackage);

        $packagistPackage->delete();

        return redirect()
            ->route('packagist-packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
