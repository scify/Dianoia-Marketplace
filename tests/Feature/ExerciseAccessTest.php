<?php

namespace Tests\Feature;

use App\Models\Resource\Resource;
use App\Models\User;
use App\Notifications\AcceptanceNotice;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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
        $this->exercise = $this->createResource($this->creator, ResourceStatusesLkp::CREATED_PENDING_APPROVAL);
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

    public function test_member_cannot_approve(): void {
        Notification::fake();

        $this->actingAs($this->otherMember)
            ->post('/resources/approve/' . $this->exercise->id, ['id' => $this->exercise->id])
            ->assertForbidden();

        $this->assertSame(ResourceStatusesLkp::CREATED_PENDING_APPROVAL, (int) $this->exercise->fresh()->status_id);
        Notification::assertNothingSent();
    }

    public function test_member_cannot_reject(): void {
        Notification::fake();

        $this->actingAs($this->otherMember)
            ->post('/resources/reject/' . $this->exercise->id, $this->rejection())
            ->assertForbidden();

        $this->assertSame(ResourceStatusesLkp::CREATED_PENDING_APPROVAL, (int) $this->exercise->fresh()->status_id);
        Notification::assertNothingSent();
    }

    public function test_admin_can_approve(): void {
        Notification::fake();

        $this->actingAs($this->admin)
            ->post('/resources/approve/' . $this->exercise->id, ['id' => $this->exercise->id])
            ->assertRedirect();

        $this->assertSame(ResourceStatusesLkp::APPROVED, (int) $this->exercise->fresh()->status_id);
        Notification::assertSentTo($this->creator, AcceptanceNotice::class);
    }

    public function test_admin_can_reject(): void {
        Notification::fake();

        $this->actingAs($this->admin)
            ->post('/resources/reject/' . $this->exercise->id, $this->rejection())
            ->assertRedirect();

        $this->assertSame(ResourceStatusesLkp::REJECTED, (int) $this->exercise->fresh()->status_id);
    }

    public function test_approve_uses_the_route_id_not_the_body_id(): void {
        Notification::fake();
        $otherExercise = $this->createResource($this->otherMember, ResourceStatusesLkp::CREATED_PENDING_APPROVAL);

        $this->actingAs($this->admin)
            ->post('/resources/approve/' . $this->exercise->id, ['id' => $otherExercise->id])
            ->assertRedirect();

        $this->assertSame(ResourceStatusesLkp::APPROVED, (int) $this->exercise->fresh()->status_id);
        $this->assertSame(ResourceStatusesLkp::CREATED_PENDING_APPROVAL, (int) $otherExercise->fresh()->status_id);
    }

    public function test_member_cannot_open_edit_form_of_other_users_exercise(): void {
        $this->actingAs($this->otherMember)
            ->get('/resources/' . $this->exercise->id . '/edit')
            ->assertForbidden();
    }

    public function test_member_cannot_update_other_users_exercise(): void {
        $this->actingAs($this->otherMember)
            ->put('/resources/' . $this->exercise->id, ['name' => 'Hijacked', 'type_id' => 1])
            ->assertForbidden();

        $this->assertSame('Test exercise', $this->exercise->fresh()->name);
    }

    public function test_creator_can_open_edit_form(): void {
        $this->actingAs($this->creator)
            ->get('/resources/' . $this->exercise->id . '/edit')
            ->assertOk();
    }

    public function test_admin_can_open_edit_form(): void {
        $this->actingAs($this->admin)
            ->get('/resources/' . $this->exercise->id . '/edit')
            ->assertOk();
    }

    public function test_admin_update_keeps_the_creator(): void {
        $this->actingAs($this->admin)
            ->put('/resources/' . $this->exercise->id, [
                'name' => 'Edited by admin',
                'description' => 'Edited',
                'lang' => 1,
                'difficulty_id' => 1,
                'type_id' => 1,
                'accept-guideline-terms' => 'on',
                'accept-privacy-terms' => 'on',
            ])
            ->assertRedirect();

        $exercise = $this->exercise->fresh();
        $this->assertSame('Edited by admin', $exercise->name);
        $this->assertSame($this->creator->id, (int) $exercise->creator_user_id);
    }

    public function test_creator_can_upload_a_pdf_when_none_exists(): void {
        Storage::fake('public');
        $this->assertNull($this->exercise->pdf_path);

        $this->actingAs($this->creator)
            ->put('/resources/' . $this->exercise->id, [
                'name' => 'With PDF',
                'description' => 'Edited',
                'lang' => 1,
                'difficulty_id' => 1,
                'type_id' => 1,
                'accept-guideline-terms' => 'on',
                'accept-privacy-terms' => 'on',
                'pdf' => UploadedFile::fake()->create('exercise.pdf', 10, 'application/pdf'),
            ])
            ->assertSessionHas('flash_message_success');

        $this->assertNotNull($this->exercise->fresh()->pdf_path);
    }

    private function rejection(): array {
        return ['id' => $this->exercise->id, 'rejection_reason' => 'Rules', 'rejection_comment' => 'Not allowed'];
    }

    private function deleteUrl(): string {
        return '/resources/delete/exercise/' . $this->exercise->id;
    }
}
