<?php

namespace Tests;

use App\Models\Resource\Resource;
use App\Models\User;
use App\Repository\Resource\ResourceStatusesLkp;
use Database\Seeders\ContentLanguageLkpSeeder;
use Database\Seeders\DifficultiesLkpSeeder;
use Database\Seeders\ResourceStatusLkpTableSeeder;
use Database\Seeders\ResourceTypeLkpTableSeeder;
use Database\Seeders\UserRoleLkpTableSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use RuntimeException;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    protected function setUp(): void {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * The database traits wipe the database before each test. A cached config
     * or a DATABASE_URL can point the tests at a real database, so refuse
     * anything other than SQLite in memory before the traits run.
     */
    protected function setUpTraits() {
        $uses = class_uses_recursive(static::class);

        if (isset($uses[RefreshDatabase::class]) || isset($uses[DatabaseMigrations::class]) || isset($uses[DatabaseTruncation::class])) {
            $this->ensureTestDatabaseIsInMemory();
        }

        return parent::setUpTraits();
    }

    protected function ensureTestDatabaseIsInMemory(): void {
        $connection = DB::connection();
        $driver = $connection->getConfig('driver');
        $database = $connection->getConfig('database');

        if ($driver !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                "Tests must use SQLite in memory, not [{$driver}] database [{$database}]. "
                . 'Run "php artisan config:clear" and check DATABASE_URL.'
            );
        }
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

    protected function createResource(User $creator, int $statusId = ResourceStatusesLkp::APPROVED): Resource {
        return Resource::create([
            'name' => 'Test exercise',
            'slug' => 'test-exercise-' . uniqid(),
            'status_id' => $statusId,
            'lang_id' => 1,
            'type_id' => 1,
            'difficulty_id' => 1,
            'creator_user_id' => $creator->id,
            'description' => 'Test description',
        ]);
    }

    protected function createUserWithRole(int $roleId): User {
        $user = User::factory()->create();
        $user->roles()->attach($roleId);

        return $user->fresh();
    }
}
