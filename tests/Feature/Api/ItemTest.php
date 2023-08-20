<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;

use App\Models\Vendor;
use App\Models\ItemType;
use App\Models\GithubRepo;
use App\Models\NpmPackage;
use App\Models\PackagistPackage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
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
    public function it_gets_items_list(): void
    {
        $items = Item::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.items.index'));

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item(): void
    {
        $data = Item::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.items.store'), $data);

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.items.update', $item), $data);

        $data['id'] = $item->id;

        $this->assertDatabaseHas('items', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->deleteJson(route('api.items.destroy', $item));

        $this->assertModelMissing($item);

        $response->assertNoContent();
    }
}
