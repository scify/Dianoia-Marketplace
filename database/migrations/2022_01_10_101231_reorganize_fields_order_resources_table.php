<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ReorganizeFieldsOrderResourcesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // Column order is cosmetic and MySQL-only syntax, so other drivers (SQLite in tests) skip it.
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE resources MODIFY COLUMN slug VARCHAR(255) AFTER name');
        DB::statement('ALTER TABLE resources MODIFY COLUMN description VARCHAR(255) AFTER name');
        DB::statement('ALTER TABLE resources MODIFY COLUMN avg_rating INTEGER AFTER pdf_path');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down() {
        // not applicable
    }
}
