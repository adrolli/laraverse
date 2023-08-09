<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubRepo;
use App\Models\GithubOrganization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOrganizationGithubReposTest extends TestCase
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
    public function it_gets_github_organization_github_repos(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();
        $githubRepos = GithubRepo::factory()
            ->count(2)
            ->create([
                'github_organization_id' => $githubOrganization->id,
            ]);

        $response = $this->getJson(
            route(
                'api.github-organizations.github-repos.index',
                $githubOrganization
            )
        );

        $response->assertOk()->assertSee($githubRepos[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_organization_github_repos(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();
        $data = GithubRepo::factory()
            ->make([
                'github_organization_id' => $githubOrganization->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.github-organizations.github-repos.store',
                $githubOrganization
            ),
            $data
        );

        $this->assertDatabaseHas('github_repos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $githubRepo = GithubRepo::latest('id')->first();

        $this->assertEquals(
            $githubOrganization->id,
            $githubRepo->github_organization_id
        );
    }
}
