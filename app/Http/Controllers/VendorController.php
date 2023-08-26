<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Vendor;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Vendor::class);

        $search = $request->get('search', '');

        $vendors = Vendor::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.vendors.index', compact('vendors', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Vendor::class);

        $owners = Owner::pluck('title', 'id');
        $organizations = Organization::pluck('title', 'id');

        return view('app.vendors.create', compact('owners', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Vendor::class);

        $validated = $request->validated();
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public');
        }

        $vendor = Vendor::create($validated);

        return redirect()
            ->route('vendors.edit', $vendor)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Vendor $vendor): View
    {
        $this->authorize('view', $vendor);

        return view('app.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Vendor $vendor): View
    {
        $this->authorize('update', $vendor);

        $owners = Owner::pluck('title', 'id');
        $organizations = Organization::pluck('title', 'id');

        return view(
            'app.vendors.edit',
            compact('vendor', 'owners', 'organizations')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        VendorUpdateRequest $request,
        Vendor $vendor
    ): RedirectResponse {
        $this->authorize('update', $vendor);

        $validated = $request->validated();
        if ($request->hasFile('avatar')) {
            if ($vendor->avatar) {
                Storage::delete($vendor->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('public');
        }

        $vendor->update($validated);

        return redirect()
            ->route('vendors.edit', $vendor)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Vendor $vendor): RedirectResponse
    {
        $this->authorize('delete', $vendor);

        if ($vendor->avatar) {
            Storage::delete($vendor->avatar);
        }

        $vendor->delete();

        return redirect()
            ->route('vendors.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
