<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ItemResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;

class ItemController extends Controller
{
    public function index(Request $request): ItemCollection
    {
        $this->authorize('view-any', Item::class);

        $search = $request->get('search', '');

        $items = Item::search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(ItemStoreRequest $request): ItemResource
    {
        $this->authorize('create', Item::class);

        $validated = $request->validated();

        $item = Item::create($validated);

        return new ItemResource($item);
    }

    public function show(Request $request, Item $item): ItemResource
    {
        $this->authorize('view', $item);

        return new ItemResource($item);
    }

    public function update(ItemUpdateRequest $request, Item $item): ItemResource
    {
        $this->authorize('update', $item);

        $validated = $request->validated();

        $item->update($validated);

        return new ItemResource($item);
    }

    public function destroy(Request $request, Item $item): Response
    {
        $this->authorize('delete', $item);

        $item->delete();

        return response()->noContent();
    }
}
