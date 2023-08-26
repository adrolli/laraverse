<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Repository;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryItemsTest extends TestCase
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
    public function it_gets_repository_items(): void
    {
        $repository = Repository::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'repository_id' => $repository->id,
            ]);

        $response = $this->getJson(
            route('api.repositories.items.index', $repository)
        );

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_repository_items(): void
    {
        $repository = Repository::factory()->create();
        $data = Item::factory()
            ->make([
                'repository_id' => $repository->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.repositories.items.store', $repository),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($repository->id, $item->repository_id);
    }
}
