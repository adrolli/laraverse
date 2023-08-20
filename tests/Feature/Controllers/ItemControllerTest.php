<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Item;

use App\Models\Vendor;
use App\Models\ItemType;
use App\Models\GithubRepo;
use App\Models\NpmPackage;
use App\Models\PackagistPackage;

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

        $data['versions'] = json_encode($data['versions']);
        $data['rating_data'] = json_encode($data['rating_data']);
        $data['health_data'] = json_encode($data['health_data']);

        $response = $this->post(route('items.store'), $data);

        $data['versions'] = $this->castToJson($data['versions']);
        $data['rating_data'] = $this->castToJson($data['rating_data']);
        $data['health_data'] = $this->castToJson($data['health_data']);

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
        $githubRepo = GithubRepo::factory()->create();
        $npmPackage = NpmPackage::factory()->create();
        $packagistPackage = PackagistPackage::factory()->create();
        $itemType = ItemType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'latest_version' => $this->faker->text(255),
            'versions' => [],
            'website' => $this->faker->text(255),
            'popularity' => $this->faker->randomNumber(0),
            'rating' => $this->faker->randomNumber(0),
            'rating_data' => [],
            'health' => $this->faker->randomNumber(0),
            'health_data' => [],
            'github_url' => $this->faker->text(255),
            'github_stars' => $this->faker->randomNumber(0),
            'packagist_url' => $this->faker->text(255),
            'packagist_name' => $this->faker->text(255),
            'packagist_description' => $this->faker->text(255),
            'packagist_downloads' => $this->faker->randomNumber(0),
            'packagist_favers' => $this->faker->randomNumber(0),
            'npm_url' => $this->faker->text(255),
            'github_maintainers' => $this->faker->randomNumber(0),
            'vendor_id' => $vendor->id,
            'github_repo_id' => $githubRepo->id,
            'npm_package_id' => $npmPackage->id,
            'packagist_package_id' => $packagistPackage->id,
            'itemType_id' => $itemType->id,
        ];

        $data['versions'] = json_encode($data['versions']);
        $data['rating_data'] = json_encode($data['rating_data']);
        $data['health_data'] = json_encode($data['health_data']);

        $response = $this->put(route('items.update', $item), $data);

        $data['id'] = $item->id;

        $data['versions'] = $this->castToJson($data['versions']);
        $data['rating_data'] = $this->castToJson($data['rating_data']);
        $data['health_data'] = $this->castToJson($data['health_data']);

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
