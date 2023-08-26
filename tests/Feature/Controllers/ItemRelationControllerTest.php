<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ItemRelation;

use App\Models\Post;
use App\Models\Item;
use App\Models\ItemRelationType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemRelationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_item_relations(): void
    {
        $itemRelations = ItemRelation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('item-relations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.item_relations.index')
            ->assertViewHas('itemRelations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_item_relation(): void
    {
        $response = $this->get(route('item-relations.create'));

        $response->assertOk()->assertViewIs('app.item_relations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_item_relation(): void
    {
        $data = ItemRelation::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('item-relations.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('item_relations', $data);

        $itemRelation = ItemRelation::latest('id')->first();

        $response->assertRedirect(route('item-relations.edit', $itemRelation));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_item_relation(): void
    {
        $itemRelation = ItemRelation::factory()->create();

        $response = $this->get(route('item-relations.show', $itemRelation));

        $response
            ->assertOk()
            ->assertViewIs('app.item_relations.show')
            ->assertViewHas('itemRelation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_item_relation(): void
    {
        $itemRelation = ItemRelation::factory()->create();

        $response = $this->get(route('item-relations.edit', $itemRelation));

        $response
            ->assertOk()
            ->assertViewIs('app.item_relations.edit')
            ->assertViewHas('itemRelation');
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

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('item-relations.update', $itemRelation),
            $data
        );

        $data['id'] = $itemRelation->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertRedirect(route('item-relations.edit', $itemRelation));
    }

    /**
     * @test
     */
    public function it_deletes_the_item_relation(): void
    {
        $itemRelation = ItemRelation::factory()->create();

        $response = $this->delete(
            route('item-relations.destroy', $itemRelation)
        );

        $response->assertRedirect(route('item-relations.index'));

        $this->assertModelMissing($itemRelation);
    }
}
