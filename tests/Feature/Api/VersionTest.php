<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Version;

use App\Models\Item;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
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
    public function it_gets_versions_list(): void
    {
        $versions = Version::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.versions.index'));

        $response->assertOk()->assertSee($versions[0]->version);
    }

    /**
     * @test
     */
    public function it_stores_the_version(): void
    {
        $data = Version::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.versions.store'), $data);

        $this->assertDatabaseHas('versions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_version(): void
    {
        $version = Version::factory()->create();

        $item = Item::factory()->create();

        $data = [
            'version' => $this->faker->text(255),
            'item_id' => $item->id,
        ];

        $response = $this->putJson(
            route('api.versions.update', $version),
            $data
        );

        $data['id'] = $version->id;

        $this->assertDatabaseHas('versions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_version(): void
    {
        $version = Version::factory()->create();

        $response = $this->deleteJson(route('api.versions.destroy', $version));

        $this->assertModelMissing($version);

        $response->assertNoContent();
    }
}
