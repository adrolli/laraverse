<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StackCollection;

class ItemStacksController extends Controller
{
    public function index(Request $request, Item $item): StackCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $stacks = $item
            ->stacks()
            ->search($search)
            ->latest()
            ->paginate();

        return new StackCollection($stacks);
    }

    public function store(Request $request, Item $item, Stack $stack): Response
    {
        $this->authorize('update', $item);

        $item->stacks()->syncWithoutDetaching([$stack->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Item $item,
        Stack $stack
    ): Response {
        $this->authorize('update', $item);

        $item->stacks()->detach($stack);

        return response()->noContent();
    }
}
