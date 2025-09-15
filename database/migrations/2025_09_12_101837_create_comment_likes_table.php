<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentLikesTable extends Migration
{
// In 2025_09_12_101837_create_comment_likes_table.php
// In 2025_09_12_101837_create_comment_likes_table.php
public function up()
{
    Schema::create('comment_likes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('comment_id');
        $table->unsignedBigInteger('user_id');
        $table->timestamps();
        
        $table->unique(['comment_id', 'user_id']);
        $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        $table->foreign('user_id')->references('UserID')->on('carsusers')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('comment_likes');
    }
}
