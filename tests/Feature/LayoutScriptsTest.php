<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class LayoutScriptsTest extends TestCase {
    use RefreshDatabase;

    public function test_layout_exposes_base_url_for_the_frontend(): void {
        $this->get('/')
            ->assertOk()
            ->assertSee($this->baseUrlJson(url('/')), false);
    }

    public function test_base_url_includes_a_sub_path(): void {
        URL::forceRootUrl('http://localhost/marketplace');

        $this->view('common.footer-scripts')
            ->assertSee($this->baseUrlJson('http://localhost/marketplace'), false);
    }

    private function baseUrlJson(string $baseUrl): string {
        return trim(json_encode(['baseUrl' => $baseUrl]), '{}');
    }
}
