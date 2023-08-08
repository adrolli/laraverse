<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Item;

use App\Models\Type;
use App\Models\Vendor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemControllerTest extends TestCase
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
    public function it_displays_index_view_with_items(): void
    {
        $items = Item::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('items.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.items.index')
            ->assertViewHas('items');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_item(): void
    {
        $response = $this->get(route('items.create'));

        $response->assertOk()->assertViewIs('app.items.create');
    }

    /**
     * @test
     */
    public function it_stores_the_item(): void
    {
        $data = Item::factory()
            ->make()
            ->toArray();

        $data['github_json'] = json_encode($data['github_json']);

        $response = $this->post(route('items.store'), $data);

        $data['github_json'] = $this->castToJson($data['github_json']);

        $this->assertDatabaseHas('items', $data);

        $item = Item::latest('id')->first();

        $response->assertRedirect(route('items.edit', $item));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.show', $item));

        $response
            ->assertOk()
            ->assertViewIs('app.items.show')
            ->assertViewHas('item');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.edit', $item));

        $response
            ->assertOk()
            ->assertViewIs('app.items.edit')
            ->assertViewHas('item');
    }

    /**
     * @test
     */
    public function it_updates_the_item(): void
    {
        $item = Item::factory()->create();

        $vendor = Vendor::factory()->create();
        $type = Type::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'website' => $this->faker->text(255),
            'rating' => $this->faker->text(255),
            'health' => $this->faker->text(255),
            'github_url' => $this->faker->text(255),
            'github_stars' => $this->faker->randomNumber(0),
            'github_forks' => $this->faker->randomNumber(0),
            'github_json' => [],
            'packagist_url' => $this->faker->text(255),
            'packagist_name' => $this->faker->text(255),
            'packagist_description' => $this->faker->text(255),
            'packagist_downloads' => $this->faker->randomNumber(0),
            'packagist_favers' => $this->faker->randomNumber(0),
            'npm_url' => $this->faker->text(255),
            'github_maintainers' => $this->faker->randomNumber(0),
            'vendor_id' => $vendor->id,
            'type_id' => $type->id,
        ];

        $data['github_json'] = json_encode($data['github_json']);

        $response = $this->put(route('items.update', $item), $data);

        $data['id'] = $item->id;

        $data['github_json'] = $this->castToJson($data['github_json']);

        $this->assertDatabaseHas('items', $data);

        $response->assertRedirect(route('items.edit', $item));
    }

    /**
     * @test
     */
    public function it_deletes_the_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->delete(route('items.destroy', $item));

        $response->assertRedirect(route('items.index'));

        $this->assertModelMissing($item);
    }
}
