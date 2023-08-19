<?php

namespace App\Http\Controllers\Api;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemTypeResource;
use App\Http\Resources\ItemTypeCollection;
use App\Http\Requests\ItemTypeStoreRequest;
use App\Http\Requests\ItemTypeUpdateRequest;

class ItemTypeController extends Controller
{
    public function index(Request $request): ItemTypeCollection
    {
        $this->authorize('view-any', ItemType::class);

        $search = $request->get('search', '');

        $itemTypes = ItemType::search($search)
            ->latest()
            ->paginate();

        return new ItemTypeCollection($itemTypes);
    }

    public function store(ItemTypeStoreRequest $request): ItemTypeResource
    {
        $this->authorize('create', ItemType::class);

        $validated = $request->validated();

        $itemType = ItemType::create($validated);

        return new ItemTypeResource($itemType);
    }

    public function show(Request $request, ItemType $itemType): ItemTypeResource
    {
        $this->authorize('view', $itemType);

        return new ItemTypeResource($itemType);
    }

    public function update(
        ItemTypeUpdateRequest $request,
        ItemType $itemType
    ): ItemTypeResource {
        $this->authorize('update', $itemType);

        $validated = $request->validated();

        $itemType->update($validated);

        return new ItemTypeResource($itemType);
    }

    public function destroy(Request $request, ItemType $itemType): Response
    {
        $this->authorize('delete', $itemType);

        $itemType->delete();

        return response()->noContent();
    }
}
