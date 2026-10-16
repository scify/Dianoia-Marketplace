<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;

class TrustHostsTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();

        // TrustHosts is inactive in the local and testing environments.
        $this->app['env'] = 'production';
        config(['app.url' => 'https://marketplace.example.org']);
    }

    protected function tearDown(): void {
        // Trusted hosts are static on the Symfony request, so reset them for the next tests.
        Request::setTrustedHosts([]);

        parent::tearDown();
    }

    public function test_foreign_host_is_rejected(): void {
        $this->get('https://evil.example/about')->assertBadRequest();
    }

    public function test_application_host_is_accepted(): void {
        $this->get('https://marketplace.example.org/about')->assertOk();
    }

    public function test_subdomain_of_application_host_is_accepted(): void {
        $this->get('https://www.marketplace.example.org/about')->assertOk();
    }
}
