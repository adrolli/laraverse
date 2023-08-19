<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Stack;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackControllerTest extends TestCase
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
    public function it_displays_index_view_with_stacks(): void
    {
        $stacks = Stack::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('stacks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.stacks.index')
            ->assertViewHas('stacks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_stack(): void
    {
        $response = $this->get(route('stacks.create'));

        $response->assertOk()->assertViewIs('app.stacks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_stack(): void
    {
        $data = Stack::factory()
            ->make()
            ->toArray();

        $data['build'] = json_encode($data['build']);

        $response = $this->post(route('stacks.store'), $data);

        $data['build'] = $this->castToJson($data['build']);

        $this->assertDatabaseHas('stacks', $data);

        $stack = Stack::latest('id')->first();

        $response->assertRedirect(route('stacks.edit', $stack));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_stack(): void
    {
        $stack = Stack::factory()->create();

        $response = $this->get(route('stacks.show', $stack));

        $response
            ->assertOk()
            ->assertViewIs('app.stacks.show')
            ->assertViewHas('stack');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_stack(): void
    {
        $stack = Stack::factory()->create();

        $response = $this->get(route('stacks.edit', $stack));

        $response
            ->assertOk()
            ->assertViewIs('app.stacks.edit')
            ->assertViewHas('stack');
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
            'build' => [],
            'public' => $this->faker->boolean(),
            'major' => $this->faker->boolean(),
            'created_by' => $user->id,
        ];

        $data['build'] = json_encode($data['build']);

        $response = $this->put(route('stacks.update', $stack), $data);

        $data['id'] = $stack->id;

        $data['build'] = $this->castToJson($data['build']);

        $this->assertDatabaseHas('stacks', $data);

        $response->assertRedirect(route('stacks.edit', $stack));
    }

    /**
     * @test
     */
    public function it_deletes_the_stack(): void
    {
        $stack = Stack::factory()->create();

        $response = $this->delete(route('stacks.destroy', $stack));

        $response->assertRedirect(route('stacks.index'));

        $this->assertModelMissing($stack);
    }
}
