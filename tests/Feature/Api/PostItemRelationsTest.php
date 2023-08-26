<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Post;
use App\Models\ItemRelation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostItemRelationsTest extends TestCase
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
    public function it_gets_post_item_relations(): void
    {
        $post = Post::factory()->create();
        $itemRelations = ItemRelation::factory()
            ->count(2)
            ->create([
                'post_id' => $post->id,
            ]);

        $response = $this->getJson(
            route('api.posts.item-relations.index', $post)
        );

        $response->assertOk()->assertSee($itemRelations[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_post_item_relations(): void
    {
        $post = Post::factory()->create();
        $data = ItemRelation::factory()
            ->make([
                'post_id' => $post->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.posts.item-relations.store', $post),
            $data
        );

        $this->assertDatabaseHas('item_relations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $itemRelation = ItemRelation::latest('id')->first();

        $this->assertEquals($post->id, $itemRelation->post_id);
    }
}
