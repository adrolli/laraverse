<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemCommentsTest extends TestCase
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
    public function it_gets_item_comments(): void
    {
        $item = Item::factory()->create();
        $comments = Comment::factory()
            ->count(2)
            ->create([
                'item_id' => $item->id,
            ]);

        $response = $this->getJson(route('api.items.comments.index', $item));

        $response->assertOk()->assertSee($comments[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_comments(): void
    {
        $item = Item::factory()->create();
        $data = Comment::factory()
            ->make([
                'item_id' => $item->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.items.comments.store', $item),
            $data
        );

        $this->assertDatabaseHas('comments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $comment = Comment::latest('id')->first();

        $this->assertEquals($item->id, $comment->item_id);
    }
}
