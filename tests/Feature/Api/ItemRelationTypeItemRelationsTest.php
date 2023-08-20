<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ItemRelation;
use App\Models\ItemRelationType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemRelationTypeItemRelationsTest extends TestCase
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
    public function it_gets_item_relation_type_item_relations(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();
        $itemRelations = ItemRelation::factory()
            ->count(2)
            ->create([
                'item_relation_type_id' => $itemRelationType->id,
            ]);

        $response = $this->getJson(
            route(
                'api.item-relation-types.item-relations.index',
                $itemRelationType
            )
        );

        $response->assertOk()->assertSee($itemRelations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_relation_type_item_relations(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();
        $data = ItemRelation::factory()
            ->make([
                'item_relation_type_id' => $itemRelationType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.item-relation-types.item-relations.store',
                $itemRelationType
            ),
            $data
        );

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $itemRelation = ItemRelation::latest('id')->first();

        $this->assertEquals(
            $itemRelationType->id,
            $itemRelation->item_relation_type_id
        );
    }
}
