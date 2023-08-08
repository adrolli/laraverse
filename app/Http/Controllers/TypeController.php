<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TypeStoreRequest;
use App\Http\Requests\TypeUpdateRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Type::class);

        $search = $request->get('search', '');

        $types = Type::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.types.index', compact('types', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Type::class);

        return view('app.types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Type::class);

        $validated = $request->validated();

        $type = Type::create($validated);

        return redirect()
            ->route('types.edit', $type)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Type $type): View
    {
        $this->authorize('view', $type);

        return view('app.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Type $type): View
    {
        $this->authorize('update', $type);

        return view('app.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TypeUpdateRequest $request,
        Type $type
    ): RedirectResponse {
        $this->authorize('update', $type);

        $validated = $request->validated();

        $type->update($validated);

        return redirect()
            ->route('types.edit', $type)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Type $type): RedirectResponse
    {
        $this->authorize('delete', $type);

        $type->delete();

        return redirect()
            ->route('types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
