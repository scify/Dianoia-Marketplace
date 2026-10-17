<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    private const PROFESSIONAL_CARER = 3;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public function test_member_cannot_update_another_user(): void {
        $member = $this->createUserWithRole(self::PRIVATE_CARER);
        $other = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->actingAs($member)
            ->put('/users/update/' . $other->id, ['name' => 'Hacked', 'email' => 'hacked@example.test'])
            ->assertForbidden();

        $this->assertNotSame('Hacked', $other->fresh()->name);
    }

    public function test_member_cannot_grant_self_admin_with_admin_flag(): void {
        $member = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->actingAs($member)->put('/users/update/' . $member->id, $this->profile($member, ['admin' => 1]));

        $this->assertFalse($this->hasRole($member, UserRolesLkp::ADMIN));
    }

    public function test_member_cannot_grant_self_admin_with_type_id(): void {
        $member = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->actingAs($member)->put('/users/update/' . $member->id, $this->profile($member, [
            'type_id' => UserRolesLkp::ADMIN,
            'prev_type_id' => self::PRIVATE_CARER,
        ]));

        $this->assertFalse($this->hasRole($member, UserRolesLkp::ADMIN));
        $this->assertTrue($this->hasRole($member, self::PRIVATE_CARER));
    }

    public function test_member_can_change_own_name_email_and_type(): void {
        $member = $this->createUserWithRole(self::PRIVATE_CARER);

        $this->actingAs($member)
            ->put('/users/update/' . $member->id, [
                'name' => 'New Name',
                'email' => 'new-email@example.test',
                'type_id' => self::PROFESSIONAL_CARER,
                'prev_type_id' => self::PRIVATE_CARER,
            ])
            ->assertRedirect();

        $member->refresh();
        $this->assertSame('New Name', $member->name);
        $this->assertSame('new-email@example.test', $member->email);
        $this->assertTrue($this->hasRole($member, self::PROFESSIONAL_CARER));
        $this->assertFalse($this->hasRole($member, self::PRIVATE_CARER));
    }

    public function test_admin_keeps_admin_role_after_saving_own_profile(): void {
        $admin = $this->createUserWithRole(UserRolesLkp::ADMIN);
        $admin->roles()->attach(self::PRIVATE_CARER);

        $this->actingAs($admin)
            ->put('/users/update/' . $admin->id, $this->profile($admin, [
                'type_id' => self::PRIVATE_CARER,
                'prev_type_id' => self::PRIVATE_CARER,
            ]))
            ->assertRedirect();

        $this->assertTrue($this->hasRole($admin, UserRolesLkp::ADMIN));
    }

    private function profile(User $user, array $overrides = []): array {
        return array_merge(['name' => $user->name, 'email' => $user->email], $overrides);
    }

    private function hasRole(User $user, int $roleId): bool {
        return $user->fresh()->roles()->where('user_roles_lkp.id', $roleId)->exists();
    }
}
