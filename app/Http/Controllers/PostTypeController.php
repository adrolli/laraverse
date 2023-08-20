<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PostTypeStoreRequest;
use App\Http\Requests\PostTypeUpdateRequest;

class PostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PostType::class);

        $search = $request->get('search', '');

        $postTypes = PostType::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.post_types.index', compact('postTypes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PostType::class);

        return view('app.post_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostTypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', PostType::class);

        $validated = $request->validated();

        $postType = PostType::create($validated);

        return redirect()
            ->route('post-types.edit', $postType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PostType $postType): View
    {
        $this->authorize('view', $postType);

        return view('app.post_types.show', compact('postType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PostType $postType): View
    {
        $this->authorize('update', $postType);

        return view('app.post_types.edit', compact('postType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PostTypeUpdateRequest $request,
        PostType $postType
    ): RedirectResponse {
        $this->authorize('update', $postType);

        $validated = $request->validated();

        $postType->update($validated);

        return redirect()
            ->route('post-types.edit', $postType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PostType $postType
    ): RedirectResponse {
        $this->authorize('delete', $postType);

        $postType->delete();

        return redirect()
            ->route('post-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
