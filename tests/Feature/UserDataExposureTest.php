<?php

namespace Tests\Feature;

use App\Models\Reports;
use App\Models\User;
use App\Notifications\ReportResponseNotice;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserDataExposureTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private User $member;

    private User $admin;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
        $this->member = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->admin = $this->createUserWithRole(UserRolesLkp::ADMIN);
    }

    public function test_guest_and_member_cannot_list_users(): void {
        $this->getJson('/metadata/users')->assertUnauthorized();
        $this->actingAs($this->member)->getJson('/metadata/users')->assertForbidden();
    }

    public function test_admin_user_list_contains_only_id_and_name(): void {
        $users = $this->actingAs($this->admin)->getJson('/metadata/users')->assertOk()->json();

        $this->assertCount(2, $users);
        foreach ($users as $user) {
            $this->assertSame(['id', 'name'], array_keys($user));
        }
    }

    public function test_guest_and_member_cannot_read_reports(): void {
        $this->getJson('/metadata/resources/user-reports')->assertUnauthorized();
        $this->actingAs($this->member)->getJson('/metadata/resources/user-reports')->assertForbidden();
    }

    public function test_admin_can_read_reports(): void {
        $resource = $this->createResource($this->member);
        Reports::create([
            'resource_id' => $resource->id,
            'reporting_user_id' => $this->member->id,
            'reason' => 'Wrong content',
            'comment' => 'Test comment',
        ]);

        $this->actingAs($this->admin)
            ->getJson('/metadata/resources/user-reports')
            ->assertOk()
            ->assertJsonPath('0.reportData.reason', 'Wrong content');
    }

    public function test_guest_and_member_cannot_send_report_responses(): void {
        Notification::fake();

        $this->postJson('/metadata/resources/respond', $this->responsePayload())->assertUnauthorized();
        $this->actingAs($this->member)->postJson('/metadata/resources/respond', $this->responsePayload())->assertForbidden();

        Notification::assertNothingSent();
    }

    public function test_admin_can_send_report_response(): void {
        Notification::fake();

        $this->actingAs($this->admin)->post('/metadata/resources/respond', $this->responsePayload())->assertRedirect();

        Notification::assertSentTo($this->member, ReportResponseNotice::class);
    }

    public function test_resources_payload_creator_has_only_id_and_name(): void {
        $this->createResource($this->member);

        $resources = $this->getJson('/metadata/resources?status_ids=2')->assertOk()->json();

        $this->assertCount(1, $resources);
        $this->assertSame(['id', 'name'], array_keys($resources[0]['creator']));
    }

    private function responsePayload(): array {
        return [
            'response' => 'Thank you',
            'resource_name' => 'Test exercise',
            'reporting_user_id' => $this->member->id,
        ];
    }
}
