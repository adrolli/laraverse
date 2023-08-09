<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\GithubOwner;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOwnerControllerTest extends TestCase
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
    public function it_displays_index_view_with_github_owners(): void
    {
        $githubOwners = GithubOwner::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('github-owners.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.github_owners.index')
            ->assertViewHas('githubOwners');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_github_owner(): void
    {
        $response = $this->get(route('github-owners.create'));

        $response->assertOk()->assertViewIs('app.github_owners.create');
    }

    /**
     * @test
     */
    public function it_stores_the_github_owner(): void
    {
        $data = GithubOwner::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('github-owners.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_owners', $data);

        $githubOwner = GithubOwner::latest('id')->first();

        $response->assertRedirect(route('github-owners.edit', $githubOwner));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_github_owner(): void
    {
        $githubOwner = GithubOwner::factory()->create();

        $response = $this->get(route('github-owners.show', $githubOwner));

        $response
            ->assertOk()
            ->assertViewIs('app.github_owners.show')
            ->assertViewHas('githubOwner');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_github_owner(): void
    {
        $githubOwner = GithubOwner::factory()->create();

        $response = $this->get(route('github-owners.edit', $githubOwner));

        $response
            ->assertOk()
            ->assertViewIs('app.github_owners.edit')
            ->assertViewHas('githubOwner');
    }

    /**
     * @test
     */
    public function it_updates_the_github_owner(): void
    {
        $githubOwner = GithubOwner::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('github-owners.update', $githubOwner),
            $data
        );

        $data['id'] = $githubOwner->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_owners', $data);

        $response->assertRedirect(route('github-owners.edit', $githubOwner));
    }

    /**
     * @test
     */
    public function it_deletes_the_github_owner(): void
    {
        $githubOwner = GithubOwner::factory()->create();

        $response = $this->delete(route('github-owners.destroy', $githubOwner));

        $response->assertRedirect(route('github-owners.index'));

        $this->assertModelMissing($githubOwner);
    }
}
