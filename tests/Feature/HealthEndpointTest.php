<?php

namespace Tests\Feature;

use SciFY\LaravelHealthEndpoint\CheckRegistry;
use Spatie\Health\Checks\Check;
use Tests\TestCase;

/**
 * The endpoint comes from scify/laravel-health-endpoint, which has its own test suite.
 * These tests cover the app's side: the package is installed, and the production drivers select the expected checks.
 */
class HealthEndpointTest extends TestCase {
    private string $token;

    protected function setUp(): void {
        parent::setUp();

        $this->token = str_repeat('a1', 32);
        config()->set('health-endpoint.token', $this->token);
    }

    public function test_it_returns_404_with_an_empty_body_without_the_token(): void {
        $response = $this->get('/health');

        $response->assertNotFound();
        $this->assertSame('', $response->getContent());
    }

    public function test_it_returns_the_shared_contract_for_a_valid_token(): void {
        // Without a DSN, the error tracker check does not call GlitchTip during the tests.
        config()->set('sentry.dsn', null);

        $response = $this->get('/health', ['X-Health-Token' => $this->token]);

        $this->assertContains($response->status(), [200, 503]);
        $response->assertJsonPath('schema_version', '1.0')
            ->assertJsonPath('app.name', config('app.name'))
            ->assertJsonStructure(['status', 'checked_at', 'duration_ms', 'checks' => [['name', 'status', 'summary', 'duration_ms', 'meta']]]);
    }

    public function test_it_selects_the_checks_of_production_in_order(): void {
        // Production: Mailgun, a database queue with a worker, file cache and sessions, and a GlitchTip DSN.
        config()->set('mail.default', 'mailgun');
        config()->set('mail.mailers.mailgun.transport', 'mailgun');
        config()->set('queue.default', 'database');
        config()->set('queue.connections.database.driver', 'database');
        config()->set('cache.default', 'file');
        config()->set('cache.stores.file.driver', 'file');
        config()->set('session.driver', 'file');
        config()->set('sentry.dsn', 'https://publickey@glitchtip.example.org/3');

        $names = array_map(fn (Check $check): string => $check->getName(), resolve(CheckRegistry::class)->checks());

        $this->assertSame([
            'database', 'cache', 'mail', 'queue', 'schedule', 'disk', 'debug_mode', 'environment', 'error_tracker',
        ], $names);
    }
}
