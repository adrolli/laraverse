<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;

class CommentController extends Controller
{
    public function index(Request $request): CommentCollection
    {
        $this->authorize('view-any', Comment::class);

        $search = $request->get('search', '');

        $comments = Comment::search($search)
            ->latest()
            ->paginate();

        return new CommentCollection($comments);
    }

    public function store(CommentStoreRequest $request): CommentResource
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $comment = Comment::create($validated);

        return new CommentResource($comment);
    }

    public function show(Request $request, Comment $comment): CommentResource
    {
        $this->authorize('view', $comment);

        return new CommentResource($comment);
    }

    public function update(
        CommentUpdateRequest $request,
        Comment $comment
    ): CommentResource {
        $this->authorize('update', $comment);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $comment->update($validated);

        return new CommentResource($comment);
    }

    public function destroy(Request $request, Comment $comment): Response
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->noContent();
    }
}
