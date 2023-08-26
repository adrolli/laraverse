<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PackagistPackage;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackagistPackageControllerTest extends TestCase
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
    public function it_displays_index_view_with_packagist_packages(): void
    {
        $packagistPackages = PackagistPackage::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('packagist-packages.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.packagist_packages.index')
            ->assertViewHas('packagistPackages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_packagist_package(): void
    {
        $response = $this->get(route('packagist-packages.create'));

        $response->assertOk()->assertViewIs('app.packagist_packages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_packagist_package(): void
    {
        $data = PackagistPackage::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('packagist-packages.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('packagist_packages', $data);

        $packagistPackage = PackagistPackage::latest('id')->first();

        $response->assertRedirect(
            route('packagist-packages.edit', $packagistPackage)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_packagist_package(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();

        $response = $this->get(
            route('packagist-packages.show', $packagistPackage)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.packagist_packages.show')
            ->assertViewHas('packagistPackage');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_packagist_package(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();

        $response = $this->get(
            route('packagist-packages.edit', $packagistPackage)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.packagist_packages.edit')
            ->assertViewHas('packagistPackage');
    }

    /**
     * @test
     */
    public function it_updates_the_packagist_package(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'data' => [],
            'type' => $this->faker->word(),
            'repository_updated' => $this->faker->boolean(),
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(
            route('packagist-packages.update', $packagistPackage),
            $data
        );

        $data['id'] = $packagistPackage->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('packagist_packages', $data);

        $response->assertRedirect(
            route('packagist-packages.edit', $packagistPackage)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_packagist_package(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();

        $response = $this->delete(
            route('packagist-packages.destroy', $packagistPackage)
        );

        $response->assertRedirect(route('packagist-packages.index'));

        $this->assertModelMissing($packagistPackage);
    }
}
