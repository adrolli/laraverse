<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemItemsTest extends TestCase
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
    public function it_gets_item_items(): void
    {
        $item = Item::factory()->create();
        $item = Item::factory()->create();

        $item->items()->attach($item);

        $response = $this->getJson(route('api.items.items.index', $item));

        $response->assertOk()->assertSee($item->title);
    }

    /**
     * @test
     */
    public function it_can_attach_items_to_item(): void
    {
        $item = Item::factory()->create();
        $item = Item::factory()->create();

        $response = $this->postJson(
            route('api.items.items.store', [$item, $item])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $item
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_items_from_item(): void
    {
        $item = Item::factory()->create();
        $item = Item::factory()->create();

        $response = $this->deleteJson(
            route('api.items.items.store', [$item, $item])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $item
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }
}
