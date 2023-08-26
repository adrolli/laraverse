<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vendor;

use App\Models\Owner;
use App\Models\Organization;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorTest extends TestCase
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
    public function it_gets_vendors_list(): void
    {
        $vendors = Vendor::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.vendors.index'));

        $response->assertOk()->assertSee($vendors[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_vendor(): void
    {
        $data = Vendor::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.vendors.store'), $data);

        $this->assertDatabaseHas('vendors', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $organization = Organization::factory()->create();
        $owner = Owner::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'email' => $this->faker->email(),
            'website' => $this->faker->text(255),
            'github' => $this->faker->text(255),
            'packagist' => $this->faker->text(255),
            'npm' => $this->faker->text(255),
            'organization_id' => $organization->id,
            'owner_id' => $owner->id,
        ];

        $response = $this->putJson(route('api.vendors.update', $vendor), $data);

        $data['id'] = $vendor->id;

        $this->assertDatabaseHas('vendors', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->deleteJson(route('api.vendors.destroy', $vendor));

        $this->assertModelMissing($vendor);

        $response->assertNoContent();
    }
}
