<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\GithubOwner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GithubOwnerTest extends TestCase
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
    public function it_gets_github_owners_list(): void
    {
        $githubOwners = GithubOwner::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.github-owners.index'));

        $response->assertOk()->assertSee($githubOwners[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_github_owner(): void
    {
        $data = GithubOwner::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.github-owners.store'), $data);

        $this->assertDatabaseHas('github_owners', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.github-owners.update', $githubOwner),
            $data
        );

        $data['id'] = $githubOwner->id;

        $this->assertDatabaseHas('github_owners', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_github_owner(): void
    {
        $githubOwner = GithubOwner::factory()->create();

        $response = $this->deleteJson(
            route('api.github-owners.destroy', $githubOwner)
        );

        $this->assertModelMissing($githubOwner);

        $response->assertNoContent();
    }
}
