<?php

namespace App\Http\Controllers\Api;

use App\Models\Stack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class StackCommentsController extends Controller
{
    public function index(Request $request, Stack $stack): CommentCollection
    {
        $this->authorize('view', $stack);

        $search = $request->get('search', '');

        $comments = $stack
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(Request $request, Stack $stack): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'user_id' => ['required', 'exists:users,id'],
            'item_id' => ['nullable', 'exists:items,id'],
        ]);

        $comment = $stack->comments()->create($validated);

        return new CommentResource($comment);
    }
}
