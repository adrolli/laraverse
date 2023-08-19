<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTypeItemsTest extends TestCase
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
    public function it_gets_item_type_items(): void
    {
        $itemType = ItemType::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'itemType_id' => $itemType->id,
            ]);

        $response = $this->getJson(
            route('api.item-types.items.index', $itemType)
        );

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_type_items(): void
    {
        $itemType = ItemType::factory()->create();
        $data = Item::factory()
            ->make([
                'itemType_id' => $itemType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.item-types.items.store', $itemType),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($itemType->id, $item->itemType_id);
    }
}
