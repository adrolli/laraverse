<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ItemType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTypeTest extends TestCase
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
    public function it_gets_item_types_list(): void
    {
        $itemTypes = ItemType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.item-types.index'));

        $response->assertOk()->assertSee($itemTypes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_type(): void
    {
        $data = ItemType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.item-types.store'), $data);

        $this->assertDatabaseHas('item_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_item_type(): void
    {
        $itemType = ItemType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.item-types.update', $itemType),
            $data
        );

        $data['id'] = $itemType->id;

        $this->assertDatabaseHas('item_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_item_type(): void
    {
        $itemType = ItemType::factory()->create();

        $response = $this->deleteJson(
            route('api.item-types.destroy', $itemType)
        );

        $this->assertModelMissing($itemType);

        $response->assertNoContent();
    }
}
