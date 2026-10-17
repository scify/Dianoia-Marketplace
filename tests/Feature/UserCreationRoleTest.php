<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreationRoleTest extends TestCase {
    use RefreshDatabase;

    private const PROFESSIONAL_CARER = 3;

    private const UNKNOWN_ROLE = 9;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public function test_registration_rejects_unknown_role(): void {
        $this->post('/register', $this->registration(self::UNKNOWN_ROLE))->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'new-user@example.test']);
    }

    public function test_registration_rejects_admin_role(): void {
        $this->post('/register', $this->registration(UserRolesLkp::ADMIN))->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'new-user@example.test']);
    }

    public function test_registration_accepts_registered_type(): void {
        $this->post('/register', $this->registration(self::PROFESSIONAL_CARER))->assertSessionHasNoErrors();

        $user = User::where('email', 'new-user@example.test')->firstOrFail();
        $this->assertSame([self::PROFESSIONAL_CARER], $user->roles->pluck('id')->all());
    }

    public function test_admin_cannot_create_user_with_unknown_role(): void {
        $admin = $this->createUserWithRole(UserRolesLkp::ADMIN);

        $this->actingAs($admin)
            ->post('/administration/users', $this->registration(self::UNKNOWN_ROLE))
            ->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'new-user@example.test']);
    }

    private function registration(int $role): array {
        return [
            'name' => 'New User',
            'email' => 'new-user@example.test',
            'password' => 'Str0ng-Passw0rd!2026',
            'password_confirmation' => 'Str0ng-Passw0rd!2026',
            'role' => $role,
        ];
    }
}
