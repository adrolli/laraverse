<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ItemRelationType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemRelationTypeControllerTest extends TestCase
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

    /**
     * @test
     */
    public function it_displays_index_view_with_item_relation_types(): void
    {
        $itemRelationTypes = ItemRelationType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('item-relation-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.item_relation_types.index')
            ->assertViewHas('itemRelationTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_item_relation_type(): void
    {
        $response = $this->get(route('item-relation-types.create'));

        $response->assertOk()->assertViewIs('app.item_relation_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_item_relation_type(): void
    {
        $data = ItemRelationType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('item-relation-types.store'), $data);

        $this->assertDatabaseHas('item_relation_types', $data);

        $itemRelationType = ItemRelationType::latest('id')->first();

        $response->assertRedirect(
            route('item-relation-types.edit', $itemRelationType)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $response = $this->get(
            route('item-relation-types.show', $itemRelationType)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.item_relation_types.show')
            ->assertViewHas('itemRelationType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $response = $this->get(
            route('item-relation-types.edit', $itemRelationType)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.item_relation_types.edit')
            ->assertViewHas('itemRelationType');
    }

    /**
     * @test
     */
    public function it_updates_the_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(
            route('item-relation-types.update', $itemRelationType),
            $data
        );

        $data['id'] = $itemRelationType->id;

        $this->assertDatabaseHas('item_relation_types', $data);

        $response->assertRedirect(
            route('item-relation-types.edit', $itemRelationType)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $response = $this->delete(
            route('item-relation-types.destroy', $itemRelationType)
        );

        $response->assertRedirect(route('item-relation-types.index'));

        $this->assertModelMissing($itemRelationType);
    }
}
