<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubRepo;

use App\Models\GithubOwner;
use App\Models\GithubOrganization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubRepoTest extends TestCase
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
    public function it_gets_github_repos_list(): void
    {
        $githubRepos = GithubRepo::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.github-repos.index'));

        $response->assertOk()->assertSee($githubRepos[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_repo(): void
    {
        $data = GithubRepo::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.github-repos.store'), $data);

        $this->assertDatabaseHas('github_repos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();

        $githubOrganization = GithubOrganization::factory()->create();
        $githubOwner = GithubOwner::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
            'github_organization_id' => $githubOrganization->id,
            'github_owner_id' => $githubOwner->id,
        ];

        $response = $this->putJson(
            route('api.github-repos.update', $githubRepo),
            $data
        );

        $data['id'] = $githubRepo->id;

        $this->assertDatabaseHas('github_repos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->deleteJson(
            route('api.github-repos.destroy', $githubRepo)
        );

        $this->assertModelMissing($githubRepo);

        $response->assertNoContent();
    }
}
