<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class StackItemsController extends Controller
{
    public function index(Request $request, Stack $stack): ItemCollection
    {
        $this->authorize('view', $stack);

        $search = $request->get('search', '');

        $items = $stack
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(Request $request, Stack $stack, Item $item): Response
    {
        $this->authorize('update', $stack);

        $stack->items()->syncWithoutDetaching([$item->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Stack $stack,
        Item $item
    ): Response {
        $this->authorize('update', $stack);

        $stack->items()->detach($item);

        return response()->noContent();
    }
}
