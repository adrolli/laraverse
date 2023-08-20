<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\View\View;
use App\Models\ItemRelation;
use Illuminate\Http\Request;
use App\Models\ItemRelationType;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ItemRelationStoreRequest;
use App\Http\Requests\ItemRelationUpdateRequest;

class ItemRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ItemRelation::class);

        $search = $request->get('search', '');

        $itemRelations = ItemRelation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.item_relations.index',
            compact('itemRelations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ItemRelation::class);

        $items = Item::pluck('title', 'id');
        $itemRelationTypes = ItemRelationType::pluck('title', 'id');

        return view(
            'app.item_relations.create',
            compact('items', 'itemRelationTypes')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRelationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ItemRelation::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $itemRelation = ItemRelation::create($validated);

        return redirect()
            ->route('item-relations.edit', $itemRelation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ItemRelation $itemRelation): View
    {
        $this->authorize('view', $itemRelation);

        return view('app.item_relations.show', compact('itemRelation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ItemRelation $itemRelation): View
    {
        $this->authorize('update', $itemRelation);

        $items = Item::pluck('title', 'id');
        $itemRelationTypes = ItemRelationType::pluck('title', 'id');

        return view(
            'app.item_relations.edit',
            compact('itemRelation', 'items', 'itemRelationTypes')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ItemRelationUpdateRequest $request,
        ItemRelation $itemRelation
    ): RedirectResponse {
        $this->authorize('update', $itemRelation);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $itemRelation->update($validated);

        return redirect()
            ->route('item-relations.edit', $itemRelation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ItemRelation $itemRelation
    ): RedirectResponse {
        $this->authorize('delete', $itemRelation);

        $itemRelation->delete();

        return redirect()
            ->route('item-relations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
