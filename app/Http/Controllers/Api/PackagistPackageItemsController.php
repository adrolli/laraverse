<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PackagistPackage;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class PackagistPackageItemsController extends Controller
{
    public function index(
        Request $request,
        PackagistPackage $packagistPackage
    ): ItemCollection {
        $this->authorize('view', $packagistPackage);

        $search = $request->get('search', '');

        $items = $packagistPackage
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(
        Request $request,
        PackagistPackage $packagistPackage
    ): ItemResource {
        $this->authorize('create', Item::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'latest_version' => ['nullable', 'max:255', 'string'],
            'versions' => ['nullable', 'max:255', 'json'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'itemType_id' => ['required', 'exists:item_types,id'],
            'website' => ['nullable', 'max:255', 'string'],
            'ranking' => ['nullable', 'numeric'],
            'popularity' => ['nullable', 'numeric'],
            'popularity_data' => ['nullable', 'max:255', 'json'],
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
            'php_compatibility' => ['nullable', 'max:255', 'json'],
            'laravel_compatibilty' => ['nullable', 'max:255', 'json'],
            'repository_id' => ['nullable', 'exists:repositories,id'],
            'npm_package_id' => ['nullable', 'exists:npm_packages,id'],
        ]);

        $item = $packagistPackage->items()->create($validated);

        return new ItemResource($item);
    }
}
