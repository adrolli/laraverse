<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\NpmPackage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NpmPackageItemsTest extends TestCase
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
    public function it_gets_npm_package_items(): void
    {
        $npmPackage = NpmPackage::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'npm_package_id' => $npmPackage->id,
            ]);

        $response = $this->getJson(
            route('api.npm-packages.items.index', $npmPackage)
        );

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_npm_package_items(): void
    {
        $npmPackage = NpmPackage::factory()->create();
        $data = Item::factory()
            ->make([
                'npm_package_id' => $npmPackage->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.npm-packages.items.store', $npmPackage),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($npmPackage->id, $item->npm_package_id);
    }
}
