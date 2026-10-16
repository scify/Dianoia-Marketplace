<?php

namespace Tests\Feature;

use App\Models\Resource\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceRatingTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private Resource $resource;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
        $this->resource = $this->createResource($this->createUserWithRole(self::PRIVATE_CARER));
    }

    public function test_guest_cannot_rate(): void {
        $this->postJson('/metadata/resources/user-rating', ['resources_id' => $this->resource->id, 'rating' => 5])
            ->assertUnauthorized();

        $this->assertDatabaseCount('resources_ratings', 0);
    }

    public function test_member_rating_is_stored_for_the_session_user_not_the_request_user_id(): void {
        $voter = $this->createUserWithRole(self::PRIVATE_CARER);
        $otherUser = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->actingAs($voter)
            ->postJson('/metadata/resources/user-rating', [
                'user_id' => $otherUser->id,
                'resources_id' => $this->resource->id,
                'rating' => 4,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('resources_ratings', ['voter_user_id' => $voter->id, 'rating' => 4]);
        $this->assertDatabaseMissing('resources_ratings', ['voter_user_id' => $otherUser->id]);
    }

    public function test_rating_twice_keeps_one_row_and_updates_the_average(): void {
        $voter = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->rate($voter, 2);
        $this->rate($voter, 5);

        $this->assertDatabaseCount('resources_ratings', 1);
        $this->assertSame(5, (int) $this->resource->fresh()->avg_rating);
    }

    public function test_average_is_the_rounded_mean_of_all_ratings(): void {
        $this->rate($this->createUserWithRole(self::PRIVATE_CARER), 4);
        $this->rate($this->createUserWithRole(self::PRIVATE_CARER), 5);
        $this->assertSame(5, (int) $this->resource->fresh()->avg_rating);

        $this->rate($this->createUserWithRole(self::PRIVATE_CARER), 1);
        $this->assertSame(3, (int) $this->resource->fresh()->avg_rating);
    }

    public function test_member_reads_only_own_rating(): void {
        $voter = $this->createUserWithRole(self::PRIVATE_CARER);
        $otherUser = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->rate($voter, 2);
        $this->rate($otherUser, 5);

        $this->actingAs($voter)
            ->getJson('/metadata/resources/user-rating?resources_id=' . $this->resource->id . '&user_id=' . $otherUser->id)
            ->assertOk()
            ->assertJsonPath('rating', 2);
    }

    public function test_guest_cannot_read_ratings(): void {
        $this->getJson('/metadata/resources/user-rating?resources_id=' . $this->resource->id)
            ->assertUnauthorized();
    }

    public function test_average_rating_endpoint_is_gone(): void {
        $this->postJson('/metadata/resources/update-resource-avg-rating', ['id' => $this->resource->id, 'avg_rating' => 1])
            ->assertNotFound();
    }

    private function rate(User $voter, int $rating): void {
        $this->actingAs($voter)
            ->postJson('/metadata/resources/user-rating', ['resources_id' => $this->resource->id, 'rating' => $rating])
            ->assertSuccessful();
    }
}
