<?php

namespace Tests\Feature;

use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthorizationTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public static function administrationPages(): array {
        return [
            'users' => ['/administration/users'],
            'exercise management' => ['/administration/admin/exercise-management'],
            'platform statistics' => ['/administration/platform-statistics'],
        ];
    }

    public static function memberPages(): array {
        return [
            'profile' => ['/my-profile'],
            'create resource' => ['/resources/create'],
        ];
    }

    #[DataProvider('administrationPages')]
    #[DataProvider('memberPages')]
    public function test_guest_is_redirected_to_login(string $path): void {
        $this->get($path)->assertRedirect('/login');
    }

    #[DataProvider('administrationPages')]
    public function test_non_admin_cannot_open_administration_page(string $path): void {
        $this->actingAs($this->createUserWithRole(self::PRIVATE_CARER))
            ->get($path)
            ->assertForbidden();
    }

    #[DataProvider('administrationPages')]
    public function test_admin_can_open_administration_page(string $path): void {
        $this->actingAs($this->createUserWithRole(UserRolesLkp::ADMIN))
            ->get($path)
            ->assertOk();
    }

    #[DataProvider('memberPages')]
    public function test_member_can_open_member_page(string $path): void {
        $this->actingAs($this->createUserWithRole(self::PRIVATE_CARER))
            ->get($path)
            ->assertOk();
    }
}
