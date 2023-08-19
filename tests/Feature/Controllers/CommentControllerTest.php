<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Comment;

use App\Models\Item;
use App\Models\Stack;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
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
    public function it_displays_index_view_with_comments(): void
    {
        $comments = Comment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('comments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.comments.index')
            ->assertViewHas('comments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_comment(): void
    {
        $response = $this->get(route('comments.create'));

        $response->assertOk()->assertViewIs('app.comments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_comment(): void
    {
        $data = Comment::factory()
            ->make()
            ->toArray();

        $data['data'] = json_encode($data['data']);

        $response = $this->post(route('comments.store'), $data);

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('comments', $data);

        $comment = Comment::latest('id')->first();

        $response->assertRedirect(route('comments.edit', $comment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_comment(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comments.show', $comment));

        $response
            ->assertOk()
            ->assertViewIs('app.comments.show')
            ->assertViewHas('comment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_comment(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comments.edit', $comment));

        $response
            ->assertOk()
            ->assertViewIs('app.comments.edit')
            ->assertViewHas('comment');
    }

    /**
     * @test
     */
    public function it_updates_the_comment(): void
    {
        $comment = Comment::factory()->create();

        $item = Item::factory()->create();
        $user = User::factory()->create();
        $stack = Stack::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->text(),
            'type' => $this->faker->word(),
            'data' => [],
            'item_id' => $item->id,
            'user_id' => $user->id,
            'stack_id' => $stack->id,
        ];

        $data['data'] = json_encode($data['data']);

        $response = $this->put(route('comments.update', $comment), $data);

        $data['id'] = $comment->id;

        $data['data'] = $this->castToJson($data['data']);

        $this->assertDatabaseHas('comments', $data);

        $response->assertRedirect(route('comments.edit', $comment));
    }

    /**
     * @test
     */
    public function it_deletes_the_comment(): void
    {
        $comment = Comment::factory()->create();

        $response = $this->delete(route('comments.destroy', $comment));

        $response->assertRedirect(route('comments.index'));

        $this->assertModelMissing($comment);
    }
}
