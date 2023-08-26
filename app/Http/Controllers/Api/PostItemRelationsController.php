<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemRelationResource;
use App\Http\Resources\ItemRelationCollection;

class PostItemRelationsController extends Controller
{
    public function index(Request $request, Post $post): ItemRelationCollection
    {
        $this->authorize('view', $post);

        $search = $request->get('search', '');

        $itemRelations = $post
            ->itemRelations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemRelationCollection($itemRelations);
    }

    public function store(Request $request, Post $post): ItemRelationResource
    {
        $this->authorize('create', ItemRelation::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'item_id' => ['required', 'exists:items,id'],
            'itemto_id' => ['required', 'max:255'],
            'item_relation_type_id' => [
                'required',
                'exists:item_relation_types,id',
            ],
        ]);

        $itemRelation = $post->itemRelations()->create($validated);

        return new ItemRelationResource($itemRelation);
    }
}
