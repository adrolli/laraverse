<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemCollection;

class PlatformItemsController extends Controller
{
    public function index(Request $request, Platform $platform): ItemCollection
    {
        $this->authorize('view', $platform);

        $search = $request->get('search', '');

        $items = $platform
            ->items()
            ->search($search)
            ->latest()
            ->paginate();

        return new ItemCollection($items);
    }

    public function store(
        Request $request,
        Platform $platform,
        Item $item
    ): Response {
        $this->authorize('update', $platform);

        $platform->items()->syncWithoutDetaching([$item->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Platform $platform,
        Item $item
    ): Response {
        $this->authorize('update', $platform);

        $platform->items()->detach($item);

        return response()->noContent();
    }
}
