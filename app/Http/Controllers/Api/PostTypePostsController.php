<?php

namespace App\Http\Controllers\Api;

use App\Models\PostType;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class PostTypePostsController extends Controller
{
    public function index(Request $request, PostType $postType): PostCollection
    {
        $this->authorize('view', $postType);

        $search = $request->get('search', '');

        $posts = $postType
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PostCollection($posts);
    }

    public function store(Request $request, PostType $postType): PostResource
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'user_id' => ['required', 'exists:users,id'],
            'item_id' => ['nullable', 'exists:items,id'],
            'stack_id' => ['nullable', 'exists:stacks,id'],
        ]);

        $post = $postType->comments()->create($validated);

        return new PostResource($post);
    }
}
