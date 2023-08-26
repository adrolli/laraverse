<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\RepositoryType;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RepositoryTypeStoreRequest;
use App\Http\Requests\RepositoryTypeUpdateRequest;

class RepositoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', RepositoryType::class);

        $search = $request->get('search', '');

        $repositoryTypes = RepositoryType::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.repository_types.index',
            compact('repositoryTypes', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', RepositoryType::class);

        return view('app.repository_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepositoryTypeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', RepositoryType::class);

        $validated = $request->validated();

        $repositoryType = RepositoryType::create($validated);

        return redirect()
            ->route('repository-types.edit', $repositoryType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, RepositoryType $repositoryType): View
    {
        $this->authorize('view', $repositoryType);

        return view('app.repository_types.show', compact('repositoryType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, RepositoryType $repositoryType): View
    {
        $this->authorize('update', $repositoryType);

        return view('app.repository_types.edit', compact('repositoryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        RepositoryTypeUpdateRequest $request,
        RepositoryType $repositoryType
    ): RedirectResponse {
        $this->authorize('update', $repositoryType);

        $validated = $request->validated();

        $repositoryType->update($validated);

        return redirect()
            ->route('repository-types.edit', $repositoryType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        RepositoryType $repositoryType
    ): RedirectResponse {
        $this->authorize('delete', $repositoryType);

        $repositoryType->delete();

        return redirect()
            ->route('repository-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
