<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class ItemCategoriesController extends Controller
{
    public function index(Request $request, Item $item): CategoryCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $categories = $item
            ->categories()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryCollection($categories);
    }

    public function store(
        Request $request,
        Item $item,
        Category $category
    ): Response {
        $this->authorize('update', $item);

        $item->categories()->syncWithoutDetaching([$category->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Item $item,
        Category $category
    ): Response {
        $this->authorize('update', $item);

        $item->categories()->detach($category);

        return response()->noContent();
    }
}
