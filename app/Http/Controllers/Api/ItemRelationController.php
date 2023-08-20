<?php

namespace App\Http\Controllers\Api;

use App\Models\ItemRelation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemRelationResource;
use App\Http\Resources\ItemRelationCollection;
use App\Http\Requests\ItemRelationStoreRequest;
use App\Http\Requests\ItemRelationUpdateRequest;

class ItemRelationController extends Controller
{
    public function index(Request $request): ItemRelationCollection
    {
        $this->authorize('view-any', ItemRelation::class);

        $search = $request->get('search', '');

        $itemRelations = ItemRelation::search($search)
            ->latest()
            ->paginate();

        return new ItemRelationCollection($itemRelations);
    }

    public function store(
        ItemRelationStoreRequest $request
    ): ItemRelationResource {
        $this->authorize('create', ItemRelation::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $itemRelation = ItemRelation::create($validated);

        return new ItemRelationResource($itemRelation);
    }

    public function show(
        Request $request,
        ItemRelation $itemRelation
    ): ItemRelationResource {
        $this->authorize('view', $itemRelation);

        return new ItemRelationResource($itemRelation);
    }

    public function update(
        ItemRelationUpdateRequest $request,
        ItemRelation $itemRelation
    ): ItemRelationResource {
        $this->authorize('update', $itemRelation);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $itemRelation->update($validated);

        return new ItemRelationResource($itemRelation);
    }

    public function destroy(
        Request $request,
        ItemRelation $itemRelation
    ): Response {
        $this->authorize('delete', $itemRelation);

        $itemRelation->delete();

        return response()->noContent();
    }
}
