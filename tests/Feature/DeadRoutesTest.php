<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DeadRoutesTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    public static function removedRoutes(): array {
        return [
            'resource destroy' => ['delete', '/resources/1'],
            'clone' => ['get', '/resources/clone/1'],
            'download' => ['get', '/resources/download/1'],
            'approve pending packages' => ['get', '/resources/approve_pending_packages'],
            'update resource' => ['put', '/resources/update_resource/1/1'],
            'submit' => ['post', '/resources/submit'],
        ];
    }

    #[DataProvider('removedRoutes')]
    public function test_route_to_a_missing_controller_method_does_not_exist(string $method, string $uri): void {
        $this->seedLookupTables();
        $member = $this->createUserWithRole(self::PRIVATE_CARER);
        $this->createResource($member);

        $status = $this->actingAs($member)->call(strtoupper($method), $uri)->getStatusCode();

        $this->assertContains($status, [404, 405], "{$method} {$uri} returned {$status}");
    }
}
