<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class ItemCommentsController extends Controller
{
    public function index(Request $request, Item $item): CommentCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $comments = $item
            ->comments()
            ->search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(Request $request, Item $item): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['nullable', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
            'data' => ['nullable', 'max:255', 'json'],
            'user_id' => ['required', 'exists:users,id'],
            'stack_id' => ['nullable', 'exists:stacks,id'],
        ]);

        $comment = $item->comments()->create($validated);

        return new CommentResource($comment);
    }
}
