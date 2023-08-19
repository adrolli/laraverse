<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stack;
use App\Models\Comment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackCommentsTest extends TestCase
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
    public function it_gets_stack_comments(): void
    {
        $stack = Stack::factory()->create();
        $comments = Comment::factory()
            ->count(2)
            ->create([
                'stack_id' => $stack->id,
            ]);

        $response = $this->getJson(route('api.stacks.comments.index', $stack));

        $response->assertOk()->assertSee($comments[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_stack_comments(): void
    {
        $stack = Stack::factory()->create();
        $data = Comment::factory()
            ->make([
                'stack_id' => $stack->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stacks.comments.store', $stack),
            $data
        );

        $this->assertDatabaseHas('comments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $comment = Comment::latest('id')->first();

        $this->assertEquals($stack->id, $comment->stack_id);
    }
}
