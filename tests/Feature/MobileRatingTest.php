<?php

namespace Tests\Feature;

use App\Models\Resource\Resource;
use App\Repository\Resource\ResourceStatusesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MobileRatingTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private Resource $approved;

    private Resource $pending;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
        $creator = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->approved = $this->createResource($creator, ResourceStatusesLkp::APPROVED);
        $this->pending = $this->createResource($creator, ResourceStatusesLkp::CREATED_PENDING_APPROVAL);
    }

    public function test_rating_by_id_is_stored(): void {
        $this->postJson('/mobile/resources/user-rating', ['resources_id' => $this->approved->id, 'rating' => 4, 'update' => false])
            ->assertOk()
            ->assertJsonPath('num_of_ratings', 1);

        $this->assertDatabaseHas('resources_ratings', [
            'resources_id' => $this->approved->id,
            'resources_slug' => $this->approved->slug,
            'rating' => 4,
        ]);
        $this->assertSame(4, (int) $this->approved->fresh()->avg_rating);
    }

    public function test_rating_by_slug_is_stored(): void {
        $this->postJson('/mobile/resources/user-rating', ['resources_slug' => $this->approved->slug, 'rating' => 5, 'update' => false])
            ->assertOk()
            ->assertJsonPath('num_of_ratings', 1);

        $this->assertSame(5, (int) $this->approved->fresh()->avg_rating);
    }

    public function test_unapproved_exercise_cannot_be_rated_by_id(): void {
        $this->postJson('/mobile/resources/user-rating', ['resources_id' => $this->pending->id, 'rating' => 1, 'update' => false])
            ->assertUnprocessable();

        $this->assertDatabaseCount('resources_ratings', 0);
    }

    public function test_unapproved_exercise_cannot_be_rated_by_slug(): void {
        $this->postJson('/mobile/resources/user-rating', ['resources_slug' => $this->pending->slug, 'rating' => 1, 'update' => false])
            ->assertUnprocessable();

        $this->assertDatabaseCount('resources_ratings', 0);
    }

    public function test_update_changes_the_previous_rating(): void {
        $this->rateApproved(['rating' => 2, 'update' => false]);

        $this->rateApproved(['rating' => 5, 'update' => true, 'previous_rating' => 2])->assertOk();

        $this->assertDatabaseCount('resources_ratings', 1);
        $this->assertDatabaseHas('resources_ratings', ['resources_id' => $this->approved->id, 'rating' => 5]);
    }

    public function test_update_without_a_matching_previous_rating_stores_a_new_rating(): void {
        $this->rateApproved(['rating' => 3, 'update' => true, 'previous_rating' => 1])->assertOk();

        $this->assertDatabaseHas('resources_ratings', ['resources_id' => $this->approved->id, 'rating' => 3]);
    }

    public function test_update_requires_the_previous_rating(): void {
        $this->rateApproved(['rating' => 3, 'update' => true])->assertUnprocessable();
    }

    private function rateApproved(array $data): TestResponse {
        return $this->postJson('/mobile/resources/user-rating', array_merge(['resources_id' => $this->approved->id], $data));
    }
}
