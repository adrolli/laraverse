<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\NpmPackage;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NpmPackageControllerTest extends TestCase
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
    public function it_displays_index_view_with_npm_packages(): void
    {
        $npmPackages = NpmPackage::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('npm-packages.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.npm_packages.index')
            ->assertViewHas('npmPackages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_npm_package(): void
    {
        $response = $this->get(route('npm-packages.create'));

        $response->assertOk()->assertViewIs('app.npm_packages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_npm_package(): void
    {
        $data = NpmPackage::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('npm-packages.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('npm_packages', $data);

        $npmPackage = NpmPackage::latest('id')->first();

        $response->assertRedirect(route('npm-packages.edit', $npmPackage));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_npm_package(): void
    {
        $npmPackage = NpmPackage::factory()->create();

        $response = $this->get(route('npm-packages.show', $npmPackage));

        $response
            ->assertOk()
            ->assertViewIs('app.npm_packages.show')
            ->assertViewHas('npmPackage');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_npm_package(): void
    {
        $npmPackage = NpmPackage::factory()->create();

        $response = $this->get(route('npm-packages.edit', $npmPackage));

        $response
            ->assertOk()
            ->assertViewIs('app.npm_packages.edit')
            ->assertViewHas('npmPackage');
    }

    /**
     * @test
     */
    public function it_updates_the_npm_package(): void
    {
        $npmPackage = NpmPackage::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('npm-packages.update', $npmPackage),
            $data
        );

        $data['id'] = $npmPackage->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('npm_packages', $data);

        $response->assertRedirect(route('npm-packages.edit', $npmPackage));
    }

    /**
     * @test
     */
    public function it_deletes_the_npm_package(): void
    {
        $npmPackage = NpmPackage::factory()->create();

        $response = $this->delete(route('npm-packages.destroy', $npmPackage));

        $response->assertRedirect(route('npm-packages.index'));

        $this->assertModelMissing($npmPackage);
    }
}
