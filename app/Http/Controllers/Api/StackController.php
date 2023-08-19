<?php

namespace App\Http\Controllers\Api;

use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StackResource;
use App\Http\Resources\StackCollection;
use App\Http\Requests\StackStoreRequest;
use App\Http\Requests\StackUpdateRequest;

class StackController extends Controller
{
    public function index(Request $request): StackCollection
    {
        $this->authorize('view-any', Stack::class);

        $search = $request->get('search', '');

        $stacks = Stack::search($search)
            ->latest()
            ->paginate();

        return new StackCollection($stacks);
    }

    public function store(StackStoreRequest $request): StackResource
    {
        $this->authorize('create', Stack::class);

        $validated = $request->validated();
        $validated['build'] = json_decode($validated['build'], true);

        $stack = Stack::create($validated);

        return new StackResource($stack);
    }

    public function show(Request $request, Stack $stack): StackResource
    {
        $this->authorize('view', $stack);

        return new StackResource($stack);
    }

    public function update(
        StackUpdateRequest $request,
        Stack $stack
    ): StackResource {
        $this->authorize('update', $stack);

        $validated = $request->validated();

        $validated['build'] = json_decode($validated['build'], true);

        $stack->update($validated);

        return new StackResource($stack);
    }

    public function destroy(Request $request, Stack $stack): Response
    {
        $this->authorize('delete', $stack);

        $stack->delete();

        return response()->noContent();
    }
}
