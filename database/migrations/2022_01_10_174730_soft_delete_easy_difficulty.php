<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class SoftDeleteEasyDifficulty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw('UPDATE resources SET difficulty_id = 2 WHERE difficulty_id = 1');
        \App\Models\DifficultiesLkp::where('code', 'EASY')->first()->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\DifficultiesLkp::create([
            'name' => "Εύκολης Δυσκολίας",
            'code' => "EASY",
        ]);
    }
}
