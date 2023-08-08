<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use App\Models\User;
use App\Models\Item;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTagsTest extends TestCase
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
    public function it_gets_item_tags(): void
    {
        $item = Item::factory()->create();
        $tag = Tag::factory()->create();

        $item->tags()->attach($tag);

        $response = $this->getJson(route('api.items.tags.index', $item));

        $response->assertOk()->assertSee($tag->title);
    }

    /**
     * @test
     */
    public function it_can_attach_tags_to_item(): void
    {
        $item = Item::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->postJson(
            route('api.items.tags.store', [$item, $tag])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $item
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tags_from_item(): void
    {
        $item = Item::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->deleteJson(
            route('api.items.tags.store', [$item, $tag])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $item
                ->tags()
                ->where('tags.id', $tag->id)
                ->exists()
        );
    }
}
