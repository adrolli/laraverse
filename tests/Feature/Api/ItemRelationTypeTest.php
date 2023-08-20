<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ItemRelationType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemRelationTypeTest extends TestCase
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
    public function it_gets_item_relation_types_list(): void
    {
        $itemRelationTypes = ItemRelationType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.item-relation-types.index'));

        $response->assertOk()->assertSee($itemRelationTypes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_item_relation_type(): void
    {
        $data = ItemRelationType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.item-relation-types.store'),
            $data
        );

        $this->assertDatabaseHas('item_relation_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.item-relation-types.update', $itemRelationType),
            $data
        );

        $data['id'] = $itemRelationType->id;

        $this->assertDatabaseHas('item_relation_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_item_relation_type(): void
    {
        $itemRelationType = ItemRelationType::factory()->create();

        $response = $this->deleteJson(
            route('api.item-relation-types.destroy', $itemRelationType)
        );

        $this->assertModelMissing($itemRelationType);

        $response->assertNoContent();
    }
}
