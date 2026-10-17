<?php

namespace Tests\Feature;

use App\Models\Resource\Resource;
use App\Models\User;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExerciseAccessTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private User $creator;

    private User $otherMember;

    private User $admin;

    private Resource $exercise;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
        $this->creator = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->otherMember = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->admin = $this->createUserWithRole(UserRolesLkp::ADMIN);
        $this->exercise = $this->createResource($this->creator);
    }

    public function test_get_delete_route_is_gone(): void {
        $this->actingAs($this->creator)
            ->get($this->deleteUrl())
            ->assertMethodNotAllowed();

        $this->assertNotSoftDeleted($this->exercise);
    }

    public function test_member_cannot_delete_other_users_exercise(): void {
        $this->actingAs($this->otherMember)
            ->delete($this->deleteUrl())
            ->assertForbidden();

        $this->assertNotSoftDeleted($this->exercise);
    }

    public function test_creator_can_delete_own_exercise(): void {
        $this->actingAs($this->creator)
            ->delete($this->deleteUrl())
            ->assertRedirect();

        $this->assertSoftDeleted($this->exercise);
    }

    public function test_admin_can_delete_any_exercise(): void {
        $this->actingAs($this->admin)
            ->delete($this->deleteUrl())
            ->assertRedirect();

        $this->assertSoftDeleted($this->exercise);
    }

    private function deleteUrl(): string {
        return '/resources/delete/exercise/' . $this->exercise->id;
    }
}
