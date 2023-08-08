<?php
namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class TagItemsController extends Controller
{
    public function index(Request $request, Tag $tag): ItemCollection
    {
        $this->authorize('view', $tag);

        $search = $request->get('search', '');

        $items = $tag
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(Request $request, Tag $tag, Item $item): Response
    {
        $this->authorize('update', $tag);

        $tag->items()->syncWithoutDetaching([$item->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Tag $tag, Item $item): Response
    {
        $this->authorize('update', $tag);

        $tag->items()->detach($item);

        return response()->noContent();
    }
}
