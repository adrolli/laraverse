<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\GithubOrganization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOrganizationControllerTest extends TestCase
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
    public function it_displays_index_view_with_github_organizations(): void
    {
        $githubOrganizations = GithubOrganization::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('github-organizations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.github_organizations.index')
            ->assertViewHas('githubOrganizations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_github_organization(): void
    {
        $response = $this->get(route('github-organizations.create'));

        $response->assertOk()->assertViewIs('app.github_organizations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_github_organization(): void
    {
        $data = GithubOrganization::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('github-organizations.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_organizations', $data);

        $githubOrganization = GithubOrganization::latest('id')->first();

        $response->assertRedirect(
            route('github-organizations.edit', $githubOrganization)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_github_organization(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();

        $response = $this->get(
            route('github-organizations.show', $githubOrganization)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.github_organizations.show')
            ->assertViewHas('githubOrganization');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_github_organization(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();

        $response = $this->get(
            route('github-organizations.edit', $githubOrganization)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.github_organizations.edit')
            ->assertViewHas('githubOrganization');
    }

    /**
     * @test
     */
    public function it_updates_the_github_organization(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('github-organizations.update', $githubOrganization),
            $data
        );

        $data['id'] = $githubOrganization->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('github_organizations', $data);

        $response->assertRedirect(
            route('github-organizations.edit', $githubOrganization)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_github_organization(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();

        $response = $this->delete(
            route('github-organizations.destroy', $githubOrganization)
        );

        $response->assertRedirect(route('github-organizations.index'));

        $this->assertModelMissing($githubOrganization);
    }
}
