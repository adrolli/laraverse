<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Repository;

use App\Models\Owner;
use App\Models\Organization;
use App\Models\RepositoryType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
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
    public function it_gets_repositories_list(): void
    {
        $repositories = Repository::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.repositories.index'));

        $response->assertOk()->assertSee($repositories[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_repository(): void
    {
        $data = Repository::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.repositories.store'), $data);

        $this->assertDatabaseHas('repositories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_repository(): void
    {
        $repository = Repository::factory()->create();

        $organization = Organization::factory()->create();
        $owner = Owner::factory()->create();
        $repositoryType = RepositoryType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'license' => $this->faker->text(255),
            'readme' => $this->faker->text(),
            'data' => [],
            'composer' => [],
            'npm' => [],
            'code_analyzer' => [],
            'package_type' => $this->faker->text(255),
            'organization_id' => $organization->id,
            'owner_id' => $owner->id,
            'repository_type_id' => $repositoryType->id,
        ];

        $response = $this->putJson(
            route('api.repositories.update', $repository),
            $data
        );

        $data['id'] = $repository->id;

        $this->assertDatabaseHas('repositories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_repository(): void
    {
        $repository = Repository::factory()->create();

        $response = $this->deleteJson(
            route('api.repositories.destroy', $repository)
        );

        $this->assertModelMissing($repository);

        $response->assertNoContent();
    }
}
