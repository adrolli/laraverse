<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ItemTypeStoreRequest;
use App\Http\Requests\ItemTypeUpdateRequest;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ItemType::class);

        $search = $request->get('search', '');

        $itemTypes = ItemType::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.item_types.index', compact('itemTypes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ItemType::class);

        return view('app.item_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemTypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ItemType::class);

        $validated = $request->validated();

        $itemType = ItemType::create($validated);

        return redirect()
            ->route('item-types.edit', $itemType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ItemType $itemType): View
    {
        $this->authorize('view', $itemType);

        return view('app.item_types.show', compact('itemType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ItemType $itemType): View
    {
        $this->authorize('update', $itemType);

        return view('app.item_types.edit', compact('itemType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ItemTypeUpdateRequest $request,
        ItemType $itemType
    ): RedirectResponse {
        $this->authorize('update', $itemType);

        $validated = $request->validated();

        $itemType->update($validated);

        return redirect()
            ->route('item-types.edit', $itemType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ItemType $itemType
    ): RedirectResponse {
        $this->authorize('delete', $itemType);

        $itemType->delete();

        return redirect()
            ->route('item-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
