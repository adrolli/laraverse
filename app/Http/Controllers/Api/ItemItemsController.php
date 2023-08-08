<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class ItemItemsController extends Controller
{
    public function index(Request $request, Item $item): ItemCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $items = $item
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(Request $request, Item $item, Item $item): Response
    {
        $this->authorize('update', $item);

        $item->items()->syncWithoutDetaching([$item->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Item $item, Item $item): Response
    {
        $this->authorize('update', $item);

        $item->items()->detach($item);

        return response()->noContent();
    }
}
