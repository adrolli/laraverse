<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Repository;
use App\Models\RepositoryType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTypeRepositoriesTest extends TestCase
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
    public function it_gets_repository_type_repositories(): void
    {
        $repositoryType = RepositoryType::factory()->create();
        $repositories = Repository::factory()
            ->count(2)
            ->create([
                'repository_type_id' => $repositoryType->id,
            ]);

        $response = $this->getJson(
            route('api.repository-types.repositories.index', $repositoryType)
        );

        $response->assertOk()->assertSee($repositories[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_repository_type_repositories(): void
    {
        $repositoryType = RepositoryType::factory()->create();
        $data = Repository::factory()
            ->make([
                'repository_type_id' => $repositoryType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.repository-types.repositories.store', $repositoryType),
            $data
        );

        $this->assertDatabaseHas('repositories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $repository = Repository::latest('id')->first();

        $this->assertEquals(
            $repositoryType->id,
            $repository->repository_type_id
        );
    }
}
