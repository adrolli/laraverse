<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Owner;
use App\Models\Vendor;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerVendorsTest extends TestCase
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
    public function it_gets_owner_vendors(): void
    {
        $owner = Owner::factory()->create();
        $vendors = Vendor::factory()
            ->count(2)
            ->create([
                'owner_id' => $owner->id,
            ]);

        $response = $this->getJson(route('api.owners.vendors.index', $owner));

        $response->assertOk()->assertSee($vendors[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_owner_vendors(): void
    {
        $owner = Owner::factory()->create();
        $data = Vendor::factory()
            ->make([
                'owner_id' => $owner->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.owners.vendors.store', $owner),
            $data
        );

        $this->assertDatabaseHas('vendors', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vendor = Vendor::latest('id')->first();

        $this->assertEquals($owner->id, $vendor->owner_id);
    }
}
