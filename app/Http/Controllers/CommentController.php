<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Stack;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Comment::class);

        $search = $request->get('search', '');

        $comments = Comment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.comments.index', compact('comments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Comment::class);

        $users = User::pluck('name', 'id');
        $items = Item::pluck('title', 'id');
        $stacks = Stack::pluck('title', 'id');

        return view('app.comments.create', compact('users', 'items', 'stacks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $comment = Comment::create($validated);

        return redirect()
            ->route('comments.edit', $comment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Comment $comment): View
    {
        $this->authorize('view', $comment);

        return view('app.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Comment $comment): View
    {
        $this->authorize('update', $comment);

        $users = User::pluck('name', 'id');
        $items = Item::pluck('title', 'id');
        $stacks = Stack::pluck('title', 'id');

        return view(
            'app.comments.edit',
            compact('comment', 'users', 'items', 'stacks')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CommentUpdateRequest $request,
        Comment $comment
    ): RedirectResponse {
        $this->authorize('update', $comment);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $comment->update($validated);

        return redirect()
            ->route('comments.edit', $comment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Comment $comment
    ): RedirectResponse {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->route('comments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
