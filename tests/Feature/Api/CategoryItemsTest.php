<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryItemsTest extends TestCase
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
    public function it_gets_category_items(): void
    {
        $category = Category::factory()->create();
        $item = Item::factory()->create();

        $category->items()->attach($item);

        $response = $this->getJson(
            route('api.categories.items.index', $category)
        );

        $response->assertOk()->assertSee($item->title);
    }

    /**
     * @test
     */
    public function it_can_attach_items_to_category(): void
    {
        $category = Category::factory()->create();
        $item = Item::factory()->create();

        $response = $this->postJson(
            route('api.categories.items.store', [$category, $item])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $category
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_items_from_category(): void
    {
        $category = Category::factory()->create();
        $item = Item::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.items.store', [$category, $item])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $category
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }
}
