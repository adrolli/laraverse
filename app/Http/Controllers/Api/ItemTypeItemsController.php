<?php

namespace App\Http\Controllers\Api;

use App\Models\ItemType;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class ItemTypeItemsController extends Controller
{
    public function index(Request $request, ItemType $itemType): ItemCollection
    {
        $this->authorize('view', $itemType);

        $search = $request->get('search', '');

        $items = $itemType
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(Request $request, ItemType $itemType): ItemResource
    {
        $this->authorize('create', Item::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'latest_version' => ['required', 'max:255', 'string'],
            'versions' => ['nullable', 'max:255', 'json'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'website' => ['nullable', 'max:255', 'string'],
            'rating' => ['nullable', 'max:255', 'string'],
            'health' => ['nullable', 'max:255', 'string'],
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

        $item = $itemType->items()->create($validated);

        return new ItemResource($item);
    }
}
