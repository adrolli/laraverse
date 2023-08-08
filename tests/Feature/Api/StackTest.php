<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stack;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackTest extends TestCase
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
    public function it_gets_stacks_list(): void
    {
        $stacks = Stack::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.stacks.index'));

        $response->assertOk()->assertSee($stacks[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_stack(): void
    {
        $data = Stack::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.stacks.store'), $data);

        $this->assertDatabaseHas('stacks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_stack(): void
    {
        $stack = Stack::factory()->create();

        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'public' => $this->faker->boolean(),
            'major' => $this->faker->boolean(),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.stacks.update', $stack), $data);

        $data['id'] = $stack->id;

        $this->assertDatabaseHas('stacks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_stack(): void
    {
        $stack = Stack::factory()->create();

        $response = $this->deleteJson(route('api.stacks.destroy', $stack));

        $this->assertModelMissing($stack);

        $response->assertNoContent();
    }
}
