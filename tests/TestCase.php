<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\ContentLanguageLkpSeeder;
use Database\Seeders\DifficultiesLkpSeeder;
use Database\Seeders\ResourceStatusLkpTableSeeder;
use Database\Seeders\ResourceTypeLkpTableSeeder;
use Database\Seeders\UserRoleLkpTableSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    protected function setUp(): void {
        parent::setUp();

        $this->withoutVite();
    }

    protected function seedLookupTables(): void {
        // The seeders echo progress lines; keep them out of the test output.
        ob_start();

        try {
            $this->seed([
                UserRoleLkpTableSeeder::class,
                ResourceStatusLkpTableSeeder::class,
                ContentLanguageLkpSeeder::class,
                DifficultiesLkpSeeder::class,
                ResourceTypeLkpTableSeeder::class,
            ]);
        } finally {
            ob_end_clean();
        }
    }

    protected function createUserWithRole(int $roleId): User {
        $user = User::factory()->create();
        $user->roles()->attach($roleId);

        return $user->fresh();
    }
}
