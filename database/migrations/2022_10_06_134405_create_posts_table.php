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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('description')->nullable();
            $table->bigInteger('parent')->default(0);
            // =========//
            $table->string('post_type')->default("post"); // Post || Product || Store
            $table->bigInteger('post_type_id')->default(0);
            // =========//
            $table->timestamps();
            // ===================================== //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // ===================================== //
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->index();
            $table->string('image')->nullable();
            // ===================================== //
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // ===================================== //
        });

        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('post_id')->index();
            $table->timestamps();
            // ===================================== //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // ===================================== //
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('post_id')->index();
            $table->BigInteger('comment_id')->nullable()->default(0);
            $table->longText('comment')->nullable();
            $table->timestamps();
            // ===================================== //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // ===================================== //
        });

        Schema::create('post_comment_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('comment_id')->index();
            $table->timestamps();
            // ===================================== //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('post_comments')->onDelete('cascade');
            // ===================================== //
        });

        Schema::create('post_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('post_id')->index();
            $table->timestamps();
            // ===================================== //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // ===================================== //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_shares');
        Schema::dropIfExists('post_comment_likes');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('post_likes');
        Schema::dropIfExists('post_images');
        Schema::dropIfExists('posts');
    }
};
