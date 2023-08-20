<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class UserPostsController extends Controller
{
    public function index(Request $request, User $user): PostCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $posts = $user
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PostCollection($posts);
    }

    public function store(Request $request, User $user): PostResource
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'item_id' => ['nullable', 'exists:items,id'],
            'stack_id' => ['nullable', 'exists:stacks,id'],
            'post_type_id' => ['required', 'exists:post_types,id'],
        ]);

        $post = $user->comments()->create($validated);

        return new PostResource($post);
    }
}
