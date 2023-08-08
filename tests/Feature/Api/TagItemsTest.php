<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Item;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagItemsTest extends TestCase
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
    public function it_gets_tag_items(): void
    {
        $tag = Tag::factory()->create();
        $item = Item::factory()->create();

        $tag->items()->attach($item);

        $response = $this->getJson(route('api.tags.items.index', $tag));

        $response->assertOk()->assertSee($item->title);
    }

    /**
     * @test
     */
    public function it_can_attach_items_to_tag(): void
    {
        $tag = Tag::factory()->create();
        $item = Item::factory()->create();

        $response = $this->postJson(
            route('api.tags.items.store', [$tag, $item])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $tag
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_items_from_tag(): void
    {
        $tag = Tag::factory()->create();
        $item = Item::factory()->create();

        $response = $this->deleteJson(
            route('api.tags.items.store', [$tag, $item])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $tag
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }
}
