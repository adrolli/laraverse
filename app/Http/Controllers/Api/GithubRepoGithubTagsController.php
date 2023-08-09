<?php
namespace App\Http\Controllers\Api;

use App\Models\GithubTag;
use App\Models\GithubRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubTagCollection;

class GithubRepoGithubTagsController extends Controller
{
    public function index(
        Request $request,
        GithubRepo $githubRepo
    ): GithubTagCollection {
        $this->authorize('view', $githubRepo);

        $search = $request->get('search', '');

        $githubTags = $githubRepo
            ->githubTags()
            ->search($search)
            ->latest()
            ->paginate();

        return new GithubTagCollection($githubTags);
    }

    public function store(
        Request $request,
        GithubRepo $githubRepo,
        GithubTag $githubTag
    ): Response {
        $this->authorize('update', $githubRepo);

        $githubRepo->githubTags()->syncWithoutDetaching([$githubTag->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        GithubRepo $githubRepo,
        GithubTag $githubTag
    ): Response {
        $this->authorize('update', $githubRepo);

        $githubRepo->githubTags()->detach($githubTag);

        return response()->noContent();
    }
}
