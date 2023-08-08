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
            'type_id' => ['required', 'exists:types,id'],
            'website' => ['required', 'max:255', 'string'],
            'rating' => ['required', 'max:255', 'string'],
            'health' => ['required', 'max:255', 'string'],
            'github_url' => ['required', 'max:255', 'string'],
            'github_stars' => ['required', 'numeric'],
            'github_forks' => ['required', 'numeric'],
            'github_json' => ['required', 'max:255', 'json'],
            'packagist_url' => ['required', 'max:255', 'string'],
            'packagist_name' => ['required', 'max:255', 'string'],
            'packagist_description' => ['required', 'max:255', 'string'],
            'packagist_downloads' => ['required', 'numeric'],
            'packagist_favers' => ['required', 'numeric'],
            'npm_url' => ['required', 'max:255', 'string'],
            'github_maintainers' => ['required', 'numeric'],
        ]);

        $item = $vendor->items()->create($validated);

        return new ItemResource($item);
    }
}
