<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Vendor;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorItemsTest extends TestCase
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
    public function it_gets_vendor_items(): void
    {
        $vendor = Vendor::factory()->create();
        $items = Item::factory()
            ->count(2)
            ->create([
                'vendor_id' => $vendor->id,
            ]);

        $response = $this->getJson(route('api.vendors.items.index', $vendor));

        $response->assertOk()->assertSee($items[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_vendor_items(): void
    {
        $vendor = Vendor::factory()->create();
        $data = Item::factory()
            ->make([
                'vendor_id' => $vendor->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vendors.items.store', $vendor),
            $data
        );

        $this->assertDatabaseHas('items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $item = Item::latest('id')->first();

        $this->assertEquals($vendor->id, $item->vendor_id);
    }
}
