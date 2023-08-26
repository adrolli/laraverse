<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ItemRelation;

use App\Models\Post;
use App\Models\Item;
use App\Models\ItemRelationType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemRelationTest extends TestCase
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
    public function it_gets_item_relations_list(): void
    {
        $itemRelations = ItemRelation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.item-relations.index'));

        $response->assertOk()->assertSee($itemRelations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_relation(): void
    {
        $data = ItemRelation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.item-relations.store'), $data);

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_item_relation(): void
    {
        $itemRelation = ItemRelation::factory()->create();

        $itemRelationType = ItemRelationType::factory()->create();
        $post = Post::factory()->create();
        $item = Item::factory()->create();
        $item = Item::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'data' => [],
            'itemto_id' => $this->faker->randomNumber(),
            'item_relation_type_id' => $itemRelationType->id,
            'post_id' => $post->id,
            'itemto_id' => $item->id,
            'item_id' => $item->id,
        ];

        $response = $this->putJson(
            route('api.item-relations.update', $itemRelation),
            $data
        );

        $data['id'] = $itemRelation->id;

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_item_relation(): void
    {
        $itemRelation = ItemRelation::factory()->create();

        $response = $this->deleteJson(
            route('api.item-relations.destroy', $itemRelation)
        );

        $this->assertModelMissing($itemRelation);

        $response->assertNoContent();
    }
}
