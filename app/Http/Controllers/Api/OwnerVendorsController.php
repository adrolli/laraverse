<?php

namespace App\Http\Controllers\Api;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Http\Resources\VendorCollection;

class OwnerVendorsController extends Controller
{
    public function index(Request $request, Owner $owner): VendorCollection
    {
        $this->authorize('view', $owner);

        $search = $request->get('search', '');

        $vendors = $owner
            ->vendors()
            ->search($search)
            ->latest()
            ->paginate();

        return new VendorCollection($vendors);
    }

    public function store(Request $request, Owner $owner): VendorResource
    {
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
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('public');
        }

        $vendor = $owner->vendors()->create($validated);

        return new VendorResource($vendor);
    }
}
