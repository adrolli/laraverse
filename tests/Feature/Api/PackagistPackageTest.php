<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PackagistPackage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackagistPackageTest extends TestCase
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
    public function it_gets_packagist_packages_list(): void
    {
        $packagistPackages = PackagistPackage::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.packagist-packages.index'));

        $response->assertOk()->assertSee($packagistPackages[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_packagist_package(): void
    {
        $data = PackagistPackage::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.packagist-packages.store'),
            $data
        );

        $this->assertDatabaseHas('packagist_packages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.packagist-packages.update', $packagistPackage),
            $data
        );

        $data['id'] = $packagistPackage->id;

        $this->assertDatabaseHas('packagist_packages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_packagist_package(): void
    {
        $packagistPackage = PackagistPackage::factory()->create();

        $response = $this->deleteJson(
            route('api.packagist-packages.destroy', $packagistPackage)
        );

        $this->assertModelMissing($packagistPackage);

        $response->assertNoContent();
    }
}
