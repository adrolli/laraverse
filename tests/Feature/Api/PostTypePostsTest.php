<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Post;
use App\Models\PostType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTypePostsTest extends TestCase
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
    public function it_gets_post_type_posts(): void
    {
        $postType = PostType::factory()->create();
        $posts = Post::factory()
            ->count(2)
            ->create([
                'post_type_id' => $postType->id,
            ]);

        $response = $this->getJson(
            route('api.post-types.posts.index', $postType)
        );

        $response->assertOk()->assertSee($posts[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_post_type_posts(): void
    {
        $postType = PostType::factory()->create();
        $data = Post::factory()
            ->make([
                'post_type_id' => $postType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.post-types.posts.store', $postType),
            $data
        );

        $this->assertDatabaseHas('posts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $post = Post::latest('id')->first();

        $this->assertEquals($postType->id, $post->post_type_id);
    }
}
