<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SoftDeleteEasyDifficulty extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::raw('UPDATE resources SET difficulty_id = 2 WHERE difficulty_id = 1');
        $toDelete = \App\Models\DifficultiesLkp::where('code', 'EASY')->first();
        if ($toDelete) {
            $toDelete->delete();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        \App\Models\DifficultiesLkp::create([
            'name' => 'Εύκολης Δυσκολίας',
            'code' => 'EASY',
        ]);
    }
}
