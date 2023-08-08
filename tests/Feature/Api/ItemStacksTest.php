<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemStacksTest extends TestCase
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
    public function it_gets_item_stacks(): void
    {
        $item = Item::factory()->create();
        $stack = Stack::factory()->create();

        $item->stacks()->attach($stack);

        $response = $this->getJson(route('api.items.stacks.index', $item));

        $response->assertOk()->assertSee($stack->title);
    }

    /**
     * @test
     */
    public function it_can_attach_stacks_to_item(): void
    {
        $item = Item::factory()->create();
        $stack = Stack::factory()->create();

        $response = $this->postJson(
            route('api.items.stacks.store', [$item, $stack])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $item
                ->stacks()
                ->where('stacks.id', $stack->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_stacks_from_item(): void
    {
        $item = Item::factory()->create();
        $stack = Stack::factory()->create();

        $response = $this->deleteJson(
            route('api.items.stacks.store', [$item, $stack])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $item
                ->stacks()
                ->where('stacks.id', $stack->id)
                ->exists()
        );
    }
}
