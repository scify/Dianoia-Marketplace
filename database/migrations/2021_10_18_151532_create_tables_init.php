<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
        Schema::create('user_roles_lkp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('user_roles_lkp');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('resource_statuses_lkp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('content_languages_lkp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('img_path');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('resource_difficulties_lkp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('resource_types_lkp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('resource_statuses_lkp');
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->foreign('lang_id')->references('id')->on('content_languages_lkp');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('resource_types_lkp');
            $table->unsignedBigInteger('difficulty_id')->nullable();
            $table->foreign('difficulty_id')->references('id')->on('resource_difficulties_lkp');
            $table->string('img_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->unsignedBigInteger('creator_user_id');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->foreign('admin_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('resources_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resources_id');
            $table->foreign('resources_id')->references('id')->on('resources');
            $table->unsignedBigInteger('voter_user_id');
            $table->foreign('voter_user_id')->references('id')->on('users');
            $table->integer('rating');
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
        Schema::dropIfExists('resources_ratings');
        Schema::dropIfExists('resources');
        Schema::dropIfExists('resource_statuses_lkp');
        Schema::dropIfExists('content_languages_lkp');
        Schema::dropIfExists('resource_difficulties_lkp');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('user_roles_lkp');
        Schema::dropIfExists('resource_types_lkp');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('personal_access_tokens');

    }
}
