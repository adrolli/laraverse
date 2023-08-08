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
        $stacks = Stack::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.stacks.index', $user));

        $response->assertOk()->assertSee($stacks[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_user_stacks(): void
    {
        $user = User::factory()->create();
        $data = Stack::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.stacks.store', $user),
            $data
        );

        $this->assertDatabaseHas('stacks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stack = Stack::latest('id')->first();

        $this->assertEquals($user->id, $stack->user_id);
    }
}
