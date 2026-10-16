<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public static function publicPages(): array {
        return [
            'homepage' => ['/'],
            'about' => ['/about'],
            'content guidelines' => ['/content-guidelines'],
            'tutorial' => ['/tutorial'],
            'login' => ['/login'],
            'register' => ['/register'],
            'coming soon' => ['/coming-soon'],
            'exercises' => ['/resources/display_exercises'],
            'translations script' => ['/js/translations.js'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_guest_can_open_public_page(string $path): void {
        $this->get($path)->assertOk();
    }

    public function test_translations_script_is_served_as_javascript(): void {
        $this->get('/js/translations.js')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/javascript; charset=UTF-8')
            ->assertSee('window.i18n = {', false);
    }

    public function test_translations_script_keeps_the_application_cache(): void {
        Cache::put('probe', 'kept');

        $this->get('/js/translations.js')->assertOk();

        $this->assertSame('kept', Cache::get('probe'));
    }
}
