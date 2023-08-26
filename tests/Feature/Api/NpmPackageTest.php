<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\NpmPackage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NpmPackageTest extends TestCase
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
    public function it_gets_npm_packages_list(): void
    {
        $npmPackages = NpmPackage::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.npm-packages.index'));

        $response->assertOk()->assertSee($npmPackages[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_npm_package(): void
    {
        $data = NpmPackage::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.npm-packages.store'), $data);

        $this->assertDatabaseHas('npm_packages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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
            'type' => $this->faker->word(),
            'repository_updated' => $this->faker->boolean(),
        ];

        $response = $this->putJson(
            route('api.npm-packages.update', $npmPackage),
            $data
        );

        $data['id'] = $npmPackage->id;

        $this->assertDatabaseHas('npm_packages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_npm_package(): void
    {
        $npmPackage = NpmPackage::factory()->create();

        $response = $this->deleteJson(
            route('api.npm-packages.destroy', $npmPackage)
        );

        $this->assertModelMissing($npmPackage);

        $response->assertNoContent();
    }
}
