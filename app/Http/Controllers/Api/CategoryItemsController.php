<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class CategoryItemsController extends Controller
{
    public function index(Request $request, Category $category): ItemCollection
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $items = $category
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(
        Request $request,
        Category $category,
        Item $item
    ): Response {
        $this->authorize('update', $category);

        $category->items()->syncWithoutDetaching([$item->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Category $category,
        Item $item
    ): Response {
        $this->authorize('update', $category);

        $category->items()->detach($item);

        return response()->noContent();
    }
}
