<?php
namespace App\Http\Controllers\Api;

use App\Models\GithubTag;
use App\Models\GithubRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GithubRepoCollection;

class GithubTagGithubReposController extends Controller
{
    public function index(
        Request $request,
        GithubTag $githubTag
    ): GithubRepoCollection {
        $this->authorize('view', $githubTag);

        $search = $request->get('search', '');

        $githubRepos = $githubTag
            ->githubRepos()
            ->search($search)
            ->latest()
            ->paginate();

        return new GithubRepoCollection($githubRepos);
    }

    public function store(
        Request $request,
        GithubTag $githubTag,
        GithubRepo $githubRepo
    ): Response {
        $this->authorize('update', $githubTag);

        $githubTag->githubRepos()->syncWithoutDetaching([$githubRepo->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        GithubTag $githubTag,
        GithubRepo $githubRepo
    ): Response {
        $this->authorize('update', $githubTag);

        $githubTag->githubRepos()->detach($githubRepo);

        return response()->noContent();
    }
}
