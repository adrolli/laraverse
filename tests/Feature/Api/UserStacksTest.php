<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserStacksTest extends TestCase
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
    public function it_gets_user_stacks(): void
    {
        $user = User::factory()->create();
        $stack = Stack::factory()->create();

        $user->stacksUsed()->attach($stack);

        $response = $this->getJson(route('api.users.stacks.index', $user));

        $response->assertOk()->assertSee($stack->title);
    }

    /**
     * @test
     */
    public function it_can_attach_stacks_to_user(): void
    {
        $user = User::factory()->create();
        $stack = Stack::factory()->create();

        $response = $this->postJson(
            route('api.users.stacks.store', [$user, $stack])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->stacksUsed()
                ->where('stacks.id', $stack->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_stacks_from_user(): void
    {
        $user = User::factory()->create();
        $stack = Stack::factory()->create();

        $response = $this->deleteJson(
            route('api.users.stacks.store', [$user, $stack])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->stacksUsed()
                ->where('stacks.id', $stack->id)
                ->exists()
        );
    }
}
