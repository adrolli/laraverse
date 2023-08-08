<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackItemsTest extends TestCase
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
    public function it_gets_stack_items(): void
    {
        $stack = Stack::factory()->create();
        $item = Item::factory()->create();

        $stack->items()->attach($item);

        $response = $this->getJson(route('api.stacks.items.index', $stack));

        $response->assertOk()->assertSee($item->title);
    }

    /**
     * @test
     */
    public function it_can_attach_items_to_stack(): void
    {
        $stack = Stack::factory()->create();
        $item = Item::factory()->create();

        $response = $this->postJson(
            route('api.stacks.items.store', [$stack, $item])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $stack
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_items_from_stack(): void
    {
        $stack = Stack::factory()->create();
        $item = Item::factory()->create();

        $response = $this->deleteJson(
            route('api.stacks.items.store', [$stack, $item])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $stack
                ->items()
                ->where('items.id', $item->id)
                ->exists()
        );
    }
}
