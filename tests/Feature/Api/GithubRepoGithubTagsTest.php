<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubTag;
use App\Models\GithubRepo;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubRepoGithubTagsTest extends TestCase
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
    public function it_gets_github_repo_github_tags(): void
    {
        $githubRepo = GithubRepo::factory()->create();
        $githubTag = GithubTag::factory()->create();

        $githubRepo->githubTags()->attach($githubTag);

        $response = $this->getJson(
            route('api.github-repos.github-tags.index', $githubRepo)
        );

        $response->assertOk()->assertSee($githubTag->title);
    }

    /**
     * @test
     */
    public function it_can_attach_github_tags_to_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();
        $githubTag = GithubTag::factory()->create();

        $response = $this->postJson(
            route('api.github-repos.github-tags.store', [
                $githubRepo,
                $githubTag,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $githubRepo
                ->githubTags()
                ->where('github_tags.id', $githubTag->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_github_tags_from_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();
        $githubTag = GithubTag::factory()->create();

        $response = $this->deleteJson(
            route('api.github-repos.github-tags.store', [
                $githubRepo,
                $githubTag,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $githubRepo
                ->githubTags()
                ->where('github_tags.id', $githubTag->id)
                ->exists()
        );
    }
}
