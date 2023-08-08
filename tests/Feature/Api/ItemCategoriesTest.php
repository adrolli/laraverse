<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemCategoriesTest extends TestCase
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
    public function it_gets_item_categories(): void
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();

        $item->categories()->attach($category);

        $response = $this->getJson(route('api.items.categories.index', $item));

        $response->assertOk()->assertSee($category->title);
    }

    /**
     * @test
     */
    public function it_can_attach_categories_to_item(): void
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson(
            route('api.items.categories.store', [$item, $category])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $item
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_categories_from_item(): void
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();

        $response = $this->deleteJson(
            route('api.items.categories.store', [$item, $category])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $item
                ->categories()
                ->where('categories.id', $category->id)
                ->exists()
        );
    }
}
