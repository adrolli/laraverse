<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Post;

use App\Models\Item;
use App\Models\Stack;
use App\Models\PostType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_posts(): void
    {
        $posts = Post::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('posts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.posts.index')
            ->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_post(): void
    {
        $response = $this->get(route('posts.create'));

        $response->assertOk()->assertViewIs('app.posts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_post(): void
    {
        $data = Post::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('posts.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('posts', $data);

        $post = Post::latest('id')->first();

        $response->assertRedirect(route('posts.edit', $post));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.show', $post));

        $response
            ->assertOk()
            ->assertViewIs('app.posts.show')
            ->assertViewHas('post');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.edit', $post));

        $response
            ->assertOk()
            ->assertViewIs('app.posts.edit')
            ->assertViewHas('post');
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

        $data['data'] = json_encode($data['data']);

        $response = $this->put(route('posts.update', $post), $data);

        $data['id'] = $post->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('posts', $data);

        $response->assertRedirect(route('posts.edit', $post));
    }

    /**
     * @test
     */
    public function it_deletes_the_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));

        $this->assertModelMissing($post);
    }
}
