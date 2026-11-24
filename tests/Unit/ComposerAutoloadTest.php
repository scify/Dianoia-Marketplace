<?php

namespace Tests\Unit;

use Tests\TestCase;

class ComposerAutoloadTest extends TestCase {
    /**
     * Production runs "composer install --no-dev", which skips "autoload-dev".
     * Helper files that the app calls must be in "autoload".
     */
    public function test_app_helper_files_are_autoloaded_without_dev_dependencies(): void {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true, flags: JSON_THROW_ON_ERROR);

        $this->assertContains('app/Utils/UrlHelpers.php', $composer['autoload']['files'] ?? []);
        $this->assertNotContains('app/Utils/UrlHelpers.php', $composer['autoload-dev']['files'] ?? []);
    }
}
