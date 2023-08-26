<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vendor;

use App\Models\Owner;
use App\Models\Organization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorControllerTest extends TestCase
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
    public function it_displays_index_view_with_vendors(): void
    {
        $vendors = Vendor::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vendors.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.index')
            ->assertViewHas('vendors');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vendor(): void
    {
        $response = $this->get(route('vendors.create'));

        $response->assertOk()->assertViewIs('app.vendors.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vendor(): void
    {
        $data = Vendor::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vendors.store'), $data);

        $this->assertDatabaseHas('vendors', $data);

        $vendor = Vendor::latest('id')->first();

        $response->assertRedirect(route('vendors.edit', $vendor));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->get(route('vendors.show', $vendor));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.show')
            ->assertViewHas('vendor');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->get(route('vendors.edit', $vendor));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.edit')
            ->assertViewHas('vendor');
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

        $response = $this->put(route('vendors.update', $vendor), $data);

        $data['id'] = $vendor->id;

        $this->assertDatabaseHas('vendors', $data);

        $response->assertRedirect(route('vendors.edit', $vendor));
    }

    /**
     * @test
     */
    public function it_deletes_the_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->delete(route('vendors.destroy', $vendor));

        $response->assertRedirect(route('vendors.index'));

        $this->assertModelMissing($vendor);
    }
}
