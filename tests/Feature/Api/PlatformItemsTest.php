<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Platform;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatformItemsTest extends TestCase
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
    public function it_gets_platform_items(): void
    {
        $platform = Platform::factory()->create();
        $item = Item::factory()->create();

        $platform->items()->attach($item);

        $response = $this->getJson(
            route('api.platforms.items.index', $platform)
        );

        $response->assertOk()->assertSee($item->title);
    }

    /**
     * @test
     */
    public function it_can_attach_items_to_platform(): void
    {
        $platform = Platform::factory()->create();
        $item = Item::factory()->create();

        $response = $this->postJson(
            route('api.platforms.items.store', [$platform, $item])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $platform
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_items_from_platform(): void
    {
        $platform = Platform::factory()->create();
        $item = Item::factory()->create();

        $response = $this->deleteJson(
            route('api.platforms.items.store', [$platform, $item])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $platform
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }
}
