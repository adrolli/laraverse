<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StackResource;
use App\Http\Resources\StackCollection;

class UserStacksController extends Controller
{
    public function index(Request $request, User $user): StackCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $stacks = $user
            ->stacks()
            ->search($search)
            ->latest()
            ->paginate();

        return new StackCollection($stacks);
    }

    public function store(Request $request, User $user): StackResource
    {
        $this->authorize('create', Stack::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'public' => ['required', 'boolean'],
            'major' => ['required', 'boolean'],
        ]);

        $stack = $user->stacks()->create($validated);

        return new StackResource($stack);
    }
}
