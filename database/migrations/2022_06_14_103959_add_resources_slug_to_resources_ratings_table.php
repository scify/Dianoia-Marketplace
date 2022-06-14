<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResourcesSlugToResourcesRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources_ratings', function (Blueprint $table) {
            $table->string('resources_slug')->nullable()->after('resources_id');
            $table->unsignedBigInteger('resources_id')->nullable()->change();
            $table->unsignedBigInteger('voter_user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources_ratings', function (Blueprint $table) {
            //
        });
    }
}
