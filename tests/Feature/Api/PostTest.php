<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Post;

use App\Models\Item;
use App\Models\Stack;
use App\Models\PostType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
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
    public function it_gets_posts_list(): void
    {
        $posts = Post::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.posts.index'));

        $response->assertOk()->assertSee($posts[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_post(): void
    {
        $data = Post::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.posts.store'), $data);

        $this->assertDatabaseHas('posts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_post(): void
    {
        $post = Post::factory()->create();

        $item = Item::factory()->create();
        $user = User::factory()->create();
        $stack = Stack::factory()->create();
        $postType = PostType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->text(),
            'data' => [],
            'item_id' => $item->id,
            'user_id' => $user->id,
            'stack_id' => $stack->id,
            'post_type_id' => $postType->id,
        ];

        $response = $this->putJson(route('api.posts.update', $post), $data);

        $data['id'] = $post->id;

        $this->assertDatabaseHas('posts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson(route('api.posts.destroy', $post));

        $this->assertModelMissing($post);

        $response->assertNoContent();
    }
}
