<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\PackagistPackage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackagistPackageItemsTest extends TestCase
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
    public function it_gets_packagist_package_items(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'packagist_package_id' => $packagistPackage->id,
            ]);

        $response = $this->getJson(
            route('api.packagist-packages.items.index', $packagistPackage)
        );

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_packagist_package_items(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();
        $data = Item::factory()
            ->make([
                'packagist_package_id' => $packagistPackage->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.packagist-packages.items.store', $packagistPackage),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($packagistPackage->id, $item->packagist_package_id);
    }
}
