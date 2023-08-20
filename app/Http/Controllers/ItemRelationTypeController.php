<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ItemRelationType;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ItemRelationTypeStoreRequest;
use App\Http\Requests\ItemRelationTypeUpdateRequest;

class ItemRelationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ItemRelationType::class);

        $search = $request->get('search', '');

        $itemRelationTypes = ItemRelationType::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.item_relation_types.index',
            compact('itemRelationTypes', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ItemRelationType::class);

        return view('app.item_relation_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ItemRelationTypeStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ItemRelationType::class);

        $validated = $request->validated();

        $itemRelationType = ItemRelationType::create($validated);

        return redirect()
            ->route('item-relation-types.edit', $itemRelationType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ItemRelationType $itemRelationType
    ): View {
        $this->authorize('view', $itemRelationType);

        return view(
            'app.item_relation_types.show',
            compact('itemRelationType')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ItemRelationType $itemRelationType
    ): View {
        $this->authorize('update', $itemRelationType);

        return view(
            'app.item_relation_types.edit',
            compact('itemRelationType')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ItemRelationTypeUpdateRequest $request,
        ItemRelationType $itemRelationType
    ): RedirectResponse {
        $this->authorize('update', $itemRelationType);

        $validated = $request->validated();

        $itemRelationType->update($validated);

        return redirect()
            ->route('item-relation-types.edit', $itemRelationType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ItemRelationType $itemRelationType
    ): RedirectResponse {
        $this->authorize('delete', $itemRelationType);

        $itemRelationType->delete();

        return redirect()
            ->route('item-relation-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
