<?php
namespace App\Http\Controllers\Api;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RepositoryTag;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryTagCollection;

class RepositoryRepositoryTagsController extends Controller
{
    public function index(
        Request $request,
        Repository $repository
    ): RepositoryTagCollection {
        $this->authorize('view', $repository);

        $search = $request->get('search', '');

        $repositoryTags = $repository
            ->repositoryTags()
            ->search($search)
            ->latest()
            ->paginate();

        return new RepositoryTagCollection($repositoryTags);
    }

    public function store(
        Request $request,
        Repository $repository,
        RepositoryTag $repositoryTag
    ): Response {
        $this->authorize('update', $repository);

        $repository
            ->repositoryTags()
            ->syncWithoutDetaching([$repositoryTag->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Repository $repository,
        RepositoryTag $repositoryTag
    ): Response {
        $this->authorize('update', $repository);

        $repository->repositoryTags()->detach($repositoryTag);

        return response()->noContent();
    }
}
