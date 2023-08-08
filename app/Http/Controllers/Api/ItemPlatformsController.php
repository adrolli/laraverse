<?php
namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformCollection;

class ItemPlatformsController extends Controller
{
    public function index(Request $request, Item $item): PlatformCollection
    {
        $this->authorize('view', $item);

        $search = $request->get('search', '');

        $platforms = $item
            ->platforms()
            ->search($search)
            ->latest()
            ->paginate();

        return new PlatformCollection($platforms);
    }

    public function store(
        Request $request,
        Item $item,
        Platform $platform
    ): Response {
        $this->authorize('update', $item);

        $item->platforms()->syncWithoutDetaching([$platform->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Item $item,
        Platform $platform
    ): Response {
        $this->authorize('update', $item);

        $item->platforms()->detach($platform);

        return response()->noContent();
    }
}
