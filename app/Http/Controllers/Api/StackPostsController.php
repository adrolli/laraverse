<?php

namespace App\Http\Controllers\Api;

use App\Models\Stack;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class StackPostsController extends Controller
{
    public function index(Request $request, Stack $stack): PostCollection
    {
        $this->authorize('view', $stack);

        $search = $request->get('search', '');

        $posts = $stack
            ->posts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PostCollection($posts);
    }

    public function store(Request $request, Stack $stack): PostResource
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'user_id' => ['required', 'exists:users,id'],
            'item_id' => ['nullable', 'exists:items,id'],
            'post_type_id' => ['required', 'exists:post_types,id'],
        ]);

        $post = $stack->posts()->create($validated);

        return new PostResource($post);
    }
}
