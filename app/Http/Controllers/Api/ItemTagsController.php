<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagCollection;

class ItemTagsController extends Controller
{
    public function index(Request $request, Item $item): TagCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $tags = $item
            ->tags()
            ->search($search)
            ->latest()
            ->paginate();

        return new TagCollection($tags);
    }

    public function store(Request $request, Item $item, Tag $tag): Response
    {
        $this->authorize('update', $item);

        $item->tags()->syncWithoutDetaching([$tag->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Item $item, Tag $tag): Response
    {
        $this->authorize('update', $item);

        $item->tags()->detach($tag);

        return response()->noContent();
    }
}
