<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Owner;
use App\Models\Repository;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerRepositoriesTest extends TestCase
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
    public function it_gets_owner_repositories(): void
    {
        $owner = Owner::factory()->create();
        $repositories = Repository::factory()
            ->count(2)
            ->create([
                'owner_id' => $owner->id,
            ]);

        $response = $this->getJson(
            route('api.owners.repositories.index', $owner)
        );

        $response->assertOk()->assertSee($repositories[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_owner_repositories(): void
    {
        $owner = Owner::factory()->create();
        $data = Repository::factory()
            ->make([
                'owner_id' => $owner->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.owners.repositories.store', $owner),
            $data
        );

        $this->assertDatabaseHas('repositories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $repository = Repository::latest('id')->first();

        $this->assertEquals($owner->id, $repository->owner_id);
    }
}
