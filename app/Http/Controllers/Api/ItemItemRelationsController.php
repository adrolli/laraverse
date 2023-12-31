<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemRelationResource;
use App\Http\Resources\ItemRelationCollection;

class ItemItemRelationsController extends Controller
{
    public function index(Request $request, Item $item): ItemRelationCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $itemRelations = $item
            ->itemRelations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemRelationCollection($itemRelations);
    }

    public function store(Request $request, Item $item): ItemRelationResource
    {
        $this->authorize('create', ItemRelation::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'itemto_id' => ['required', 'max:255'],
            'item_relation_type_id' => [
                'required',
                'exists:item_relation_types,id',
            ],
            'post_id' => ['nullable', 'exists:posts,id'],
        ]);

        $itemRelation = $item->itemRelations()->create($validated);

        return new ItemRelationResource($itemRelation);
    }
}
