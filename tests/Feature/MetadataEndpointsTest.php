<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class MetadataEndpointsTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public static function lookupEndpoints(): array {
        return [
            'content languages' => ['/metadata/content-languages'],
            'content types' => ['/metadata/content-types'],
            'content difficulties' => ['/metadata/content-difficulties'],
            'user roles' => ['/metadata/user-roles'],
        ];
    }

    #[DataProvider('lookupEndpoints')]
    public function test_lookup_endpoint_returns_seeded_rows(string $path): void {
        $response = $this->getJson($path)->assertOk();

        $this->assertNotEmpty($response->json());
    }
}
