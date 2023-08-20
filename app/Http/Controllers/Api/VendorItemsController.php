<?php

namespace App\Http\Controllers\Api;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class VendorItemsController extends Controller
{
    public function index(Request $request, Vendor $vendor): ItemCollection
    {
        $this->authorize('view', $vendor);

        $search = $request->get('search', '');

        $items = $vendor
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(Request $request, Vendor $vendor): ItemResource
    {
        $this->authorize('create', Item::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'latest_version' => ['nullable', 'max:255', 'string'],
            'versions' => ['nullable', 'max:255', 'json'],
            'itemType_id' => ['required', 'exists:item_types,id'],
            'website' => ['nullable', 'max:255', 'string'],
            'popularity' => ['required', 'numeric'],
            'rating' => ['nullable', 'numeric'],
            'rating_data' => ['nullable', 'max:255', 'json'],
            'health' => ['nullable', 'numeric'],
            'health_data' => ['nullable', 'max:255', 'json'],
            'github_url' => ['nullable', 'max:255', 'string'],
            'github_stars' => ['nullable', 'numeric'],
            'packagist_url' => ['nullable', 'max:255', 'string'],
            'packagist_name' => ['nullable', 'max:255', 'string'],
            'packagist_description' => ['nullable', 'max:255', 'string'],
            'packagist_downloads' => ['nullable', 'numeric'],
            'packagist_favers' => ['nullable', 'numeric'],
            'npm_url' => ['nullable', 'max:255', 'string'],
            'github_maintainers' => ['nullable', 'numeric'],
            'github_repo_id' => ['nullable', 'exists:github_repos,id'],
            'npm_package_id' => ['nullable', 'exists:npm_packages,id'],
            'packagist_package_id' => [
                'nullable',
                'exists:packagist_packages,id',
            ],
        ]);

        $item = $vendor->items()->create($validated);

        return new ItemResource($item);
    }
}
