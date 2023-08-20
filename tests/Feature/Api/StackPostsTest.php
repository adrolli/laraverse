<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Post;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackPostsTest extends TestCase
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
    public function it_gets_stack_posts(): void
    {
        $stack = Stack::factory()->create();
        $posts = Post::factory()
            ->count(2)
            ->create([
                'stack_id' => $stack->id,
            ]);

        $response = $this->getJson(route('api.stacks.posts.index', $stack));

        $response->assertOk()->assertSee($posts[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_stack_posts(): void
    {
        $stack = Stack::factory()->create();
        $data = Post::factory()
            ->make([
                'stack_id' => $stack->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stacks.posts.store', $stack),
            $data
        );

        $this->assertDatabaseHas('posts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $post = Post::latest('id')->first();

        $this->assertEquals($stack->id, $post->stack_id);
    }
}
