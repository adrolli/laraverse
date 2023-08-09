<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubOrganization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOrganizationTest extends TestCase
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
    public function it_gets_github_organizations_list(): void
    {
        $githubOrganizations = GithubOrganization::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.github-organizations.index'));

        $response->assertOk()->assertSee($githubOrganizations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_organization(): void
    {
        $data = GithubOrganization::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.github-organizations.store'),
            $data
        );

        $this->assertDatabaseHas('github_organizations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.github-organizations.update', $githubOrganization),
            $data
        );

        $data['id'] = $githubOrganization->id;

        $this->assertDatabaseHas('github_organizations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_github_organization(): void
    {
        $githubOrganization = GithubOrganization::factory()->create();

        $response = $this->deleteJson(
            route('api.github-organizations.destroy', $githubOrganization)
        );

        $this->assertModelMissing($githubOrganization);

        $response->assertNoContent();
    }
}
