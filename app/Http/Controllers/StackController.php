<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stack;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StackStoreRequest;
use App\Http\Requests\StackUpdateRequest;

class StackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Stack::class);

        $search = $request->get('search', '');

        $stacks = Stack::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.stacks.index', compact('stacks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Stack::class);

        $users = User::pluck('name', 'id');

        return view('app.stacks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StackStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Stack::class);

        $validated = $request->validated();

        $stack = Stack::create($validated);

        return redirect()
            ->route('stacks.edit', $stack)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Stack $stack): View
    {
        $this->authorize('view', $stack);

        return view('app.stacks.show', compact('stack'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Stack $stack): View
    {
        $this->authorize('update', $stack);

        $users = User::pluck('name', 'id');

        return view('app.stacks.edit', compact('stack', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StackUpdateRequest $request,
        Stack $stack
    ): RedirectResponse {
        $this->authorize('update', $stack);

        $validated = $request->validated();

        $stack->update($validated);

        return redirect()
            ->route('stacks.edit', $stack)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Stack $stack): RedirectResponse
    {
        $this->authorize('delete', $stack);

        $stack->delete();

        return redirect()
            ->route('stacks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
