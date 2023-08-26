<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Http\Resources\VendorCollection;

class OrganizationVendorsController extends Controller
{
    public function index(
        Request $request,
        Organization $organization
    ): VendorCollection {
        $this->authorize('view', $organization);

        $search = $request->get('search', '');

        $vendors = $organization
            ->vendors()
            ->search($search)
            ->latest()
            ->paginate();

        return new VendorCollection($vendors);
    }

    public function store(
        Request $request,
        Organization $organization
    ): VendorResource {
        $this->authorize('create', Vendor::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'avatar' => ['nullable', 'file'],
            'description' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'max:255', 'string'],
            'github' => ['nullable', 'max:255', 'string'],
            'packagist' => ['nullable', 'max:255', 'string'],
            'npm' => ['nullable', 'max:255', 'string'],
            'owner_id' => ['nullable', 'exists:owners,id'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public');
        }

        $vendor = $organization->vendors()->create($validated);

        return new VendorResource($vendor);
    }
}
