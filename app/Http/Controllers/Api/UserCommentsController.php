<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class UserCommentsController extends Controller
{
    public function index(Request $request, User $user): CommentCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $comments = $user
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(Request $request, User $user): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'item_id' => ['nullable', 'exists:items,id'],
            'stack_id' => ['nullable', 'exists:stacks,id'],
        ]);

        $comment = $user->comments()->create($validated);

        return new CommentResource($comment);
    }
}
