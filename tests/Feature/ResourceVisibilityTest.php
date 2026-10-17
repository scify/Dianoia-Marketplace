<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceVisibilityTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private User $creator;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
        $this->creator = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->createResource($this->creator, ResourceStatusesLkp::APPROVED);
        $this->createResource($this->creator, ResourceStatusesLkp::CREATED_PENDING_APPROVAL);
        $this->createResource($this->creator, ResourceStatusesLkp::REJECTED);
    }

    public function test_guest_cannot_list_pending_or_rejected_exercises(): void {
        $this->assertSame([ResourceStatusesLkp::APPROVED], $this->statusesFor(null, $this->creator->id));
    }

    public function test_member_cannot_list_other_users_pending_or_rejected_exercises(): void {
        $otherMember = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->assertSame([ResourceStatusesLkp::APPROVED], $this->statusesFor($otherMember, $this->creator->id));
    }

    public function test_member_can_list_own_pending_and_rejected_exercises(): void {
        $this->assertSame(
            [ResourceStatusesLkp::CREATED_PENDING_APPROVAL, ResourceStatusesLkp::APPROVED, ResourceStatusesLkp::REJECTED],
            $this->statusesFor($this->creator, $this->creator->id)
        );
    }

    public function test_admin_can_list_pending_and_rejected_exercises_of_anyone(): void {
        $admin = $this->createUserWithRole(UserRolesLkp::ADMIN);

        $this->assertSame(
            [ResourceStatusesLkp::CREATED_PENDING_APPROVAL, ResourceStatusesLkp::APPROVED, ResourceStatusesLkp::REJECTED],
            $this->statusesFor($admin, null)
        );
    }

    /**
     * Requests approved, pending and rejected exercises and returns the statuses that come back.
     */
    private function statusesFor(?User $viewer, ?int $userIdToGetContent): array {
        if ($viewer) {
            $this->actingAs($viewer);
        }

        $query = 'status_ids=1,2,3' . ($userIdToGetContent ? '&user_id_to_get_content=' . $userIdToGetContent : '');
        $statuses = collect($this->getJson('/metadata/resources?' . $query)->assertOk()->json())
            ->pluck('status_id')->map(fn ($id) => (int) $id)->unique()->sort()->values()->all();

        return $statuses;
    }
}
