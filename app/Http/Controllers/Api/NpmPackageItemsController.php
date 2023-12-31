<?php

namespace App\Http\Controllers\Api;

use App\Models\NpmPackage;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class NpmPackageItemsController extends Controller
{
    public function index(
        Request $request,
        NpmPackage $npmPackage
    ): ItemCollection {
        $this->authorize('view', $npmPackage);

        $search = $request->get('search', '');

        $items = $npmPackage
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(
        Request $request,
        NpmPackage $npmPackage
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
            'packagist_package_id' => [
                'nullable',
                'exists:packagist_packages,id',
            ],
        ]);

        $item = $npmPackage->items()->create($validated);

        return new ItemResource($item);
    }
}
