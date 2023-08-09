<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubRepo;
use App\Models\GithubOwner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOwnerGithubReposTest extends TestCase
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
    public function it_gets_github_owner_github_repos(): void
    {
        $githubOwner = GithubOwner::factory()->create();
        $githubRepos = GithubRepo::factory()
            ->count(2)
            ->create([
                'github_owner_id' => $githubOwner->id,
            ]);

        $response = $this->getJson(
            route('api.github-owners.github-repos.index', $githubOwner)
        );

        $response->assertOk()->assertSee($githubRepos[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_owner_github_repos(): void
    {
        $githubOwner = GithubOwner::factory()->create();
        $data = GithubRepo::factory()
            ->make([
                'github_owner_id' => $githubOwner->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.github-owners.github-repos.store', $githubOwner),
            $data
        );

        $this->assertDatabaseHas('github_repos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $githubRepo = GithubRepo::latest('id')->first();

        $this->assertEquals($githubOwner->id, $githubRepo->github_owner_id);
    }
}
