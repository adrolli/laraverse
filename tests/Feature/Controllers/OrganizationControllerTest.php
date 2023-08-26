<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Organization;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationControllerTest extends TestCase
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
    public function it_displays_index_view_with_organizations(): void
    {
        $organizations = Organization::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('organizations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.organizations.index')
            ->assertViewHas('organizations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_organization(): void
    {
        $response = $this->get(route('organizations.create'));

        $response->assertOk()->assertViewIs('app.organizations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_organization(): void
    {
        $data = Organization::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('organizations.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('organizations', $data);

        $organization = Organization::latest('id')->first();

        $response->assertRedirect(route('organizations.edit', $organization));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_organization(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->get(route('organizations.show', $organization));

        $response
            ->assertOk()
            ->assertViewIs('app.organizations.show')
            ->assertViewHas('organization');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_organization(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->get(route('organizations.edit', $organization));

        $response
            ->assertOk()
            ->assertViewIs('app.organizations.edit')
            ->assertViewHas('organization');
    }

    /**
     * @test
     */
    public function it_updates_the_organization(): void
    {
        $organization = Organization::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('organizations.update', $organization),
            $data
        );

        $data['id'] = $organization->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('organizations', $data);

        $response->assertRedirect(route('organizations.edit', $organization));
    }

    /**
     * @test
     */
    public function it_deletes_the_organization(): void
    {
        $organization = Organization::factory()->create();

        $response = $this->delete(
            route('organizations.destroy', $organization)
        );

        $response->assertRedirect(route('organizations.index'));

        $this->assertModelMissing($organization);
    }
}
