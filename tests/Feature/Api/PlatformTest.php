<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Platform;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatformTest extends TestCase
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
    public function it_gets_platforms_list(): void
    {
        $platforms = Platform::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.platforms.index'));

        $response->assertOk()->assertSee($platforms[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_platform(): void
    {
        $data = Platform::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.platforms.store'), $data);

        $this->assertDatabaseHas('platforms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_platform(): void
    {
        $platform = Platform::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.platforms.update', $platform),
            $data
        );

        $data['id'] = $platform->id;

        $this->assertDatabaseHas('platforms', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_platform(): void
    {
        $platform = Platform::factory()->create();

        $response = $this->deleteJson(
            route('api.platforms.destroy', $platform)
        );

        $this->assertModelMissing($platform);

        $response->assertNoContent();
    }
}
