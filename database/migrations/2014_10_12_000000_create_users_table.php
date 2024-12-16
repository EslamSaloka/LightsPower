<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('username');
            $table->string('job_title')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->longText('bio')->nullable();
            $table->integer('otp')->nullable();
            $table->boolean('suspend')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamp("last_action_at")->nullable();
            $table->timestamps();
        });

        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('token')->unique();
            $table->string('devices_token')->nullable();
            $table->timestamps();
            // ============================= //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // ============================= //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tokens');
        Schema::dropIfExists('users');
    }
};
