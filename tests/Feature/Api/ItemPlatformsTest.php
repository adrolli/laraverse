<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Platform;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemPlatformsTest extends TestCase
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
    public function it_gets_item_platforms(): void
    {
        $item = Item::factory()->create();
        $platform = Platform::factory()->create();

        $item->platforms()->attach($platform);

        $response = $this->getJson(route('api.items.platforms.index', $item));

        $response->assertOk()->assertSee($platform->title);
    }

    /**
     * @test
     */
    public function it_can_attach_platforms_to_item(): void
    {
        $item = Item::factory()->create();
        $platform = Platform::factory()->create();

        $response = $this->postJson(
            route('api.items.platforms.store', [$item, $platform])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $item
                ->platforms()
                ->where('platforms.id', $platform->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_platforms_from_item(): void
    {
        $item = Item::factory()->create();
        $platform = Platform::factory()->create();

        $response = $this->deleteJson(
            route('api.items.platforms.store', [$item, $platform])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $item
                ->platforms()
                ->where('platforms.id', $platform->id)
                ->exists()
        );
    }
}
