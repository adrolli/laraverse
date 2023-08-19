<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ItemType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_item_types(): void
    {
        $itemTypes = ItemType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('item-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.item_types.index')
            ->assertViewHas('itemTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_item_type(): void
    {
        $response = $this->get(route('item-types.create'));

        $response->assertOk()->assertViewIs('app.item_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_item_type(): void
    {
        $data = ItemType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('item-types.store'), $data);

        $this->assertDatabaseHas('item_types', $data);

        $itemType = ItemType::latest('id')->first();

        $response->assertRedirect(route('item-types.edit', $itemType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_item_type(): void
    {
        $itemType = ItemType::factory()->create();

        $response = $this->get(route('item-types.show', $itemType));

        $response
            ->assertOk()
            ->assertViewIs('app.item_types.show')
            ->assertViewHas('itemType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_item_type(): void
    {
        $itemType = ItemType::factory()->create();

        $response = $this->get(route('item-types.edit', $itemType));

        $response
            ->assertOk()
            ->assertViewIs('app.item_types.edit')
            ->assertViewHas('itemType');
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

        $response = $this->put(route('item-types.update', $itemType), $data);

        $data['id'] = $itemType->id;

        $this->assertDatabaseHas('item_types', $data);

        $response->assertRedirect(route('item-types.edit', $itemType));
    }

    /**
     * @test
     */
    public function it_deletes_the_item_type(): void
    {
        $itemType = ItemType::factory()->create();

        $response = $this->delete(route('item-types.destroy', $itemType));

        $response->assertRedirect(route('item-types.index'));

        $this->assertModelMissing($itemType);
    }
}
