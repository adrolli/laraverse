<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackUsersTest extends TestCase
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
    public function it_gets_stack_users(): void
    {
        $stack = Stack::factory()->create();
        $user = User::factory()->create();

        $stack->users()->attach($user);

        $response = $this->getJson(route('api.stacks.users.index', $stack));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_stack(): void
    {
        $stack = Stack::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.stacks.users.store', [$stack, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $stack
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_stack(): void
    {
        $stack = Stack::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.stacks.users.store', [$stack, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $stack
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
