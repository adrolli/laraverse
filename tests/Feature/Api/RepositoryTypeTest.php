<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RepositoryType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTypeTest extends TestCase
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
    public function it_gets_repository_types_list(): void
    {
        $repositoryTypes = RepositoryType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.repository-types.index'));

        $response->assertOk()->assertSee($repositoryTypes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_repository_type(): void
    {
        $data = RepositoryType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.repository-types.store'), $data);

        $this->assertDatabaseHas('repository_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
        ];

        $response = $this->putJson(
            route('api.repository-types.update', $repositoryType),
            $data
        );

        $data['id'] = $repositoryType->id;

        $this->assertDatabaseHas('repository_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_repository_type(): void
    {
        $repositoryType = RepositoryType::factory()->create();

        $response = $this->deleteJson(
            route('api.repository-types.destroy', $repositoryType)
        );

        $this->assertModelMissing($repositoryType);

        $response->assertNoContent();
    }
}
