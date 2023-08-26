<?php
namespace App\Http\Controllers\Api;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RepositoryTag;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryCollection;

class RepositoryTagRepositoriesController extends Controller
{
    public function index(
        Request $request,
        RepositoryTag $repositoryTag
    ): RepositoryCollection {
        $this->authorize('view', $repositoryTag);

        $search = $request->get('search', '');

        $repositories = $repositoryTag
            ->repositories()
            ->search($search)
            ->latest()
            ->paginate();

        return new RepositoryCollection($repositories);
    }

    public function store(
        Request $request,
        RepositoryTag $repositoryTag,
        Repository $repository
    ): Response {
        $this->authorize('update', $repositoryTag);

        $repositoryTag->repositories()->syncWithoutDetaching([$repository->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        RepositoryTag $repositoryTag,
        Repository $repository
    ): Response {
        $this->authorize('update', $repositoryTag);

        $repositoryTag->repositories()->detach($repository);

        return response()->noContent();
    }
}
