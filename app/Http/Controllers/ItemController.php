<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use App\Models\Vendor;
use Illuminate\View\View;
use App\Models\GithubRepo;
use App\Models\NpmPackage;
use Illuminate\Http\Request;
use App\Models\PackagistPackage;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Item::class);

        $search = $request->get('search', '');

        $items = Item::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.items.index', compact('items', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Item::class);

        $vendors = Vendor::pluck('title', 'id');
        $types = Type::pluck('title', 'id');
        $githubRepos = GithubRepo::pluck('title', 'id');
        $npmPackages = NpmPackage::pluck('title', 'id');
        $packagistPackages = PackagistPackage::pluck('title', 'id');

        return view(
            'app.items.create',
            compact(
                'vendors',
                'types',
                'githubRepos',
                'npmPackages',
                'packagistPackages'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Item::class);

        $validated = $request->validated();

        $item = Item::create($validated);

        return redirect()
            ->route('items.edit', $item)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Item $item): View
    {
        $this->authorize('view', $item);

        return view('app.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Item $item): View
    {
        $this->authorize('update', $item);

        $vendors = Vendor::pluck('title', 'id');
        $types = Type::pluck('title', 'id');
        $githubRepos = GithubRepo::pluck('title', 'id');
        $npmPackages = NpmPackage::pluck('title', 'id');
        $packagistPackages = PackagistPackage::pluck('title', 'id');

        return view(
            'app.items.edit',
            compact(
                'item',
                'vendors',
                'types',
                'githubRepos',
                'npmPackages',
                'packagistPackages'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ItemUpdateRequest $request,
        Item $item
    ): RedirectResponse {
        $this->authorize('update', $item);

        $validated = $request->validated();

        $item->update($validated);

        return redirect()
            ->route('items.edit', $item)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Item $item): RedirectResponse
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()
            ->route('items.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
