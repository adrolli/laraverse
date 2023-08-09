<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubTag;
use App\Models\GithubRepo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubTagGithubReposTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_github_tag_github_repos(): void
    {
        $githubTag = GithubTag::factory()->create();
        $githubRepo = GithubRepo::factory()->create();

        $githubTag->githubRepos()->attach($githubRepo);

        $response = $this->getJson(
            route('api.github-tags.github-repos.index', $githubTag)
        );

        $response->assertOk()->assertSee($githubRepo->title);
    }

    /**
     * @test
     */
    public function it_can_attach_github_repos_to_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->postJson(
            route('api.github-tags.github-repos.store', [
                $githubTag,
                $githubRepo,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $githubTag
                ->githubRepos()
                ->where('github_repos.id', $githubRepo->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_github_repos_from_github_tag(): void
    {
        $githubTag = GithubTag::factory()->create();
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->deleteJson(
            route('api.github-tags.github-repos.store', [
                $githubTag,
                $githubRepo,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $githubTag
                ->githubRepos()
                ->where('github_repos.id', $githubRepo->id)
                ->exists()
        );
    }
}
