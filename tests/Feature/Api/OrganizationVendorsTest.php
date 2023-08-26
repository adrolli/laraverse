<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Organization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationVendorsTest extends TestCase
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
    public function it_gets_organization_vendors(): void
    {
        $organization = Organization::factory()->create();
        $vendors = Vendor::factory()
            ->count(2)
            ->create([
                'organization_id' => $organization->id,
            ]);

        $response = $this->getJson(
            route('api.organizations.vendors.index', $organization)
        );

        $response->assertOk()->assertSee($vendors[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_organization_vendors(): void
    {
        $organization = Organization::factory()->create();
        $data = Vendor::factory()
            ->make([
                'organization_id' => $organization->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.organizations.vendors.store', $organization),
            $data
        );

        $this->assertDatabaseHas('vendors', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vendor = Vendor::latest('id')->first();

        $this->assertEquals($organization->id, $vendor->organization_id);
    }
}
