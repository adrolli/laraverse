<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ItemRelationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemRelationTypeResource;
use App\Http\Resources\ItemRelationTypeCollection;
use App\Http\Requests\ItemRelationTypeStoreRequest;
use App\Http\Requests\ItemRelationTypeUpdateRequest;

class ItemRelationTypeController extends Controller
{
    public function index(Request $request): ItemRelationTypeCollection
    {
        $this->authorize('view-any', ItemRelationType::class);

        $search = $request->get('search', '');

        $itemRelationTypes = ItemRelationType::search($search)
            ->latest()
            ->paginate();

        return new ItemRelationTypeCollection($itemRelationTypes);
    }

    public function store(
        ItemRelationTypeStoreRequest $request
    ): ItemRelationTypeResource {
        $this->authorize('create', ItemRelationType::class);

        $validated = $request->validated();

        $itemRelationType = ItemRelationType::create($validated);

        return new ItemRelationTypeResource($itemRelationType);
    }

    public function show(
        Request $request,
        ItemRelationType $itemRelationType
    ): ItemRelationTypeResource {
        $this->authorize('view', $itemRelationType);

        return new ItemRelationTypeResource($itemRelationType);
    }

    public function update(
        ItemRelationTypeUpdateRequest $request,
        ItemRelationType $itemRelationType
    ): ItemRelationTypeResource {
        $this->authorize('update', $itemRelationType);

        $validated = $request->validated();

        $itemRelationType->update($validated);

        return new ItemRelationTypeResource($itemRelationType);
    }

    public function destroy(
        Request $request,
        ItemRelationType $itemRelationType
    ): Response {
        $this->authorize('delete', $itemRelationType);

        $itemRelationType->delete();

        return response()->noContent();
    }
}
