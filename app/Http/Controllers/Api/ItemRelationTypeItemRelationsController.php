<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ItemRelationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemRelationResource;
use App\Http\Resources\ItemRelationCollection;

class ItemRelationTypeItemRelationsController extends Controller
{
    public function index(
        Request $request,
        ItemRelationType $itemRelationType
    ): ItemRelationCollection {
        $this->authorize('view', $itemRelationType);

        $search = $request->get('search', '');

        $itemRelations = $itemRelationType
            ->itemRelations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemRelationCollection($itemRelations);
    }

    public function store(
        Request $request,
        ItemRelationType $itemRelationType
    ): ItemRelationResource {
        $this->authorize('create', ItemRelation::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'item_id' => ['required', 'exists:items,id'],
        ]);

        $itemRelation = $itemRelationType->itemRelations()->create($validated);

        return new ItemRelationResource($itemRelation);
    }
}
