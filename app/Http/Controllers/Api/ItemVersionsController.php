<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use App\Http\Resources\VersionCollection;

class ItemVersionsController extends Controller
{
    public function index(Request $request, Item $item): VersionCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $versions = $item
            ->versions()
            ->search($search)
            ->latest()
            ->paginate();

        return new VersionCollection($versions);
    }

    public function store(Request $request, Item $item): VersionResource
    {
        $this->authorize('create', Version::class);

        $validated = $request->validate([
            'version' => ['required', 'max:255', 'string'],
        ]);

        $version = $item->versions()->create($validated);

        return new VersionResource($version);
    }
}
