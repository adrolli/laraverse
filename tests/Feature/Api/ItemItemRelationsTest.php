<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemRelation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemItemRelationsTest extends TestCase
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
    public function it_gets_item_item_relations(): void
    {
        $item = Item::factory()->create();
        $itemRelations = ItemRelation::factory()
            ->count(2)
            ->create([
                'item_id' => $item->id,
            ]);

        $response = $this->getJson(
            route('api.items.item-relations.index', $item)
        );

        $response->assertOk()->assertSee($itemRelations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_item_relations(): void
    {
        $item = Item::factory()->create();
        $data = ItemRelation::factory()
            ->make([
                'item_id' => $item->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.items.item-relations.store', $item),
            $data
        );

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $itemRelation = ItemRelation::latest('id')->first();

        $this->assertEquals($item->id, $itemRelation->item_id);
    }
}
