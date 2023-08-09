<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\GithubRepo;

use App\Models\GithubOwner;
use App\Models\GithubOrganization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubRepoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_github_repos(): void
    {
        $githubRepos = GithubRepo::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('github-repos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.github_repos.index')
            ->assertViewHas('githubRepos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_github_repo(): void
    {
        $response = $this->get(route('github-repos.create'));

        $response->assertOk()->assertViewIs('app.github_repos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_github_repo(): void
    {
        $data = GithubRepo::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('github-repos.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_repos', $data);

        $githubRepo = GithubRepo::latest('id')->first();

        $response->assertRedirect(route('github-repos.edit', $githubRepo));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->get(route('github-repos.show', $githubRepo));

        $response
            ->assertOk()
            ->assertViewIs('app.github_repos.show')
            ->assertViewHas('githubRepo');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->get(route('github-repos.edit', $githubRepo));

        $response
            ->assertOk()
            ->assertViewIs('app.github_repos.edit')
            ->assertViewHas('githubRepo');
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

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('github-repos.update', $githubRepo),
            $data
        );

        $data['id'] = $githubRepo->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_repos', $data);

        $response->assertRedirect(route('github-repos.edit', $githubRepo));
    }

    /**
     * @test
     */
    public function it_deletes_the_github_repo(): void
    {
        $githubRepo = GithubRepo::factory()->create();

        $response = $this->delete(route('github-repos.destroy', $githubRepo));

        $response->assertRedirect(route('github-repos.index'));

        $this->assertModelMissing($githubRepo);
    }
}
