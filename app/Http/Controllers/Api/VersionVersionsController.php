<?php
namespace App\Http\Controllers\Api;

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VersionCollection;

class VersionVersionsController extends Controller
{
    public function index(Request $request, Version $version): VersionCollection
    {
        $this->authorize('view', $version);

        $search = $request->get('search', '');

        $versions = $version
            ->versions()
            ->search($search)
            ->latest()
            ->paginate();

        return new VersionCollection($versions);
    }

    public function store(
        Request $request,
        Version $version,
        Version $version
    ): Response {
        $this->authorize('update', $version);

        $version->versions()->syncWithoutDetaching([$version->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Version $version,
        Version $version
    ): Response {
        $this->authorize('update', $version);

        $version->versions()->detach($version);

        return response()->noContent();
    }
}
