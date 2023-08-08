<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Type;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeTest extends TestCase
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
    public function it_gets_types_list(): void
    {
        $types = Type::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.types.index'));

        $response->assertOk()->assertSee($types[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_type(): void
    {
        $data = Type::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.types.store'), $data);

        $this->assertDatabaseHas('types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_type(): void
    {
        $type = Type::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(route('api.types.update', $type), $data);

        $data['id'] = $type->id;

        $this->assertDatabaseHas('types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_type(): void
    {
        $type = Type::factory()->create();

        $response = $this->deleteJson(route('api.types.destroy', $type));

        $this->assertModelMissing($type);

        $response->assertNoContent();
    }
}
