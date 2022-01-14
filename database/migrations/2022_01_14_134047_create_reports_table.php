<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('resources_id');
            $table->foreign('resources_id')->references('id')->on('resources');
            $table->unsignedBigInteger('reporting_user_id');
            $table->foreign('reporting_user_id')->references('id')->on('users');
            $table->string('reason');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
