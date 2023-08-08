<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Version;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionVersionsTest extends TestCase
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
    public function it_gets_version_versions(): void
    {
        $version = Version::factory()->create();
        $version = Version::factory()->create();

        $version->versions()->attach($version);

        $response = $this->getJson(
            route('api.versions.versions.index', $version)
        );

        $response->assertOk()->assertSee($version->version);
    }

    /**
     * @test
     */
    public function it_can_attach_versions_to_version(): void
    {
        $version = Version::factory()->create();
        $version = Version::factory()->create();

        $response = $this->postJson(
            route('api.versions.versions.store', [$version, $version])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $version
                ->versions()
                ->where('versions.id', $version->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_versions_from_version(): void
    {
        $version = Version::factory()->create();
        $version = Version::factory()->create();

        $response = $this->deleteJson(
            route('api.versions.versions.store', [$version, $version])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $version
                ->versions()
                ->where('versions.id', $version->id)
                ->exists()
        );
    }
}
