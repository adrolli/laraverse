<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\View\View;
use App\Models\Repository;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\RepositoryType;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RepositoryStoreRequest;
use App\Http\Requests\RepositoryUpdateRequest;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Repository::class);

        $search = $request->get('search', '');

        $repositories = Repository::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.repositories.index',
            compact('repositories', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Repository::class);

        $repositoryTypes = RepositoryType::pluck('title', 'id');
        $organizations = Organization::pluck('title', 'id');
        $owners = Owner::pluck('title', 'id');

        return view(
            'app.repositories.create',
            compact('repositoryTypes', 'organizations', 'owners')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepositoryStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Repository::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $validated['composer'] = json_decode($validated['composer'], true);

        $validated['npm'] = json_decode($validated['npm'], true);

        $validated['code_analyzer'] = json_decode(
            $validated['code_analyzer'],
            true
        );

        $repository = Repository::create($validated);

        return redirect()
            ->route('repositories.edit', $repository)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Repository $repository): View
    {
        $this->authorize('view', $repository);

        return view('app.repositories.show', compact('repository'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Repository $repository): View
    {
        $this->authorize('update', $repository);

        $repositoryTypes = RepositoryType::pluck('title', 'id');
        $organizations = Organization::pluck('title', 'id');
        $owners = Owner::pluck('title', 'id');

        return view(
            'app.repositories.edit',
            compact('repository', 'repositoryTypes', 'organizations', 'owners')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        RepositoryUpdateRequest $request,
        Repository $repository
    ): RedirectResponse {
        $this->authorize('update', $repository);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $validated['composer'] = json_decode($validated['composer'], true);

        $validated['npm'] = json_decode($validated['npm'], true);

        $validated['code_analyzer'] = json_decode(
            $validated['code_analyzer'],
            true
        );

        $repository->update($validated);

        return redirect()
            ->route('repositories.edit', $repository)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Repository $repository
    ): RedirectResponse {
        $this->authorize('delete', $repository);

        $repository->delete();

        return redirect()
            ->route('repositories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
