<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Post;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemPostsTest extends TestCase
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
    public function it_gets_item_posts(): void
    {
        $item = Item::factory()->create();
        $posts = Post::factory()
            ->count(2)
            ->create([
                'item_id' => $item->id,
            ]);

        $response = $this->getJson(route('api.items.posts.index', $item));

        $response->assertOk()->assertSee($posts[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_posts(): void
    {
        $item = Item::factory()->create();
        $data = Post::factory()
            ->make([
                'item_id' => $item->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.items.posts.store', $item),
            $data
        );

        $this->assertDatabaseHas('posts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $post = Post::latest('id')->first();

        $this->assertEquals($item->id, $post->item_id);
    }
}
