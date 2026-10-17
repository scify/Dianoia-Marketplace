<?php

namespace Tests\Feature;

use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTypeTest extends TestCase {
    use RefreshDatabase;

    private const PROFESSIONAL_CARER = 3;

    private const ORGANIZATION = 4;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public function test_admin_page_preselects_the_admins_registered_type(): void {
        $admin = $this->createUserWithRole(UserRolesLkp::ADMIN);
        $admin->roles()->attach(self::PROFESSIONAL_CARER);

        $html = $this->actingAs($admin->fresh())
            ->get('/administration/admin/exercise-management')
            ->assertOk()
            ->assertSee('name="prev_type_id" value="' . self::PROFESSIONAL_CARER . '"', false)
            ->getContent();

        $this->assertMatchesRegularExpression('/<option value="' . self::PROFESSIONAL_CARER . '"\s+selected>/', $html);
    }

    public function test_profile_page_preselects_the_members_type(): void {
        $member = $this->createUserWithRole(self::ORGANIZATION);

        $this->actingAs($member)
            ->get('/my-profile')
            ->assertOk()
            ->assertSee('name="prev_type_id" value="' . self::ORGANIZATION . '"', false);
    }

    public function test_admin_without_registered_type_can_open_admin_page(): void {
        $this->actingAs($this->createUserWithRole(UserRolesLkp::ADMIN))
            ->get('/administration/admin/exercise-management')
            ->assertOk();
    }

    public function test_admin_without_registered_type_gets_an_empty_type_option(): void {
        $html = $this->actingAs($this->createUserWithRole(UserRolesLkp::ADMIN))
            ->get('/administration/admin/exercise-management')
            ->assertOk()
            ->getContent();

        $this->assertMatchesRegularExpression('/<option value=""\s+selected>/', $html);
        $this->assertStringNotContainsString('>messages.<', $html);
    }

    public function test_saving_with_an_empty_type_keeps_the_roles(): void {
        $admin = $this->createUserWithRole(UserRolesLkp::ADMIN);

        $this->actingAs($admin)
            ->put('/users/update/' . $admin->id, ['name' => $admin->name, 'email' => $admin->email, 'type_id' => ''])
            ->assertSessionHasNoErrors();

        $this->assertSame([UserRolesLkp::ADMIN], $admin->fresh()->roles->pluck('id')->all());
    }
}
