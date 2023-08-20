<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class ItemPostsController extends Controller
{
    public function index(Request $request, Item $item): PostCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $posts = $item
            ->posts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PostCollection($posts);
    }

    public function store(Request $request, Item $item): PostResource
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'user_id' => ['required', 'exists:users,id'],
            'stack_id' => ['nullable', 'exists:stacks,id'],
            'post_type_id' => ['required', 'exists:post_types,id'],
        ]);

        $post = $item->posts()->create($validated);

        return new PostResource($post);
    }
}
