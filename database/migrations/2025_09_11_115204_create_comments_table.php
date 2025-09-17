<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCommentsTable extends Migration
{
public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->text('message');
        $table->string('name');
        $table->string('email');
        $table->unsignedBigInteger('car_id')->nullable()->default(null); // FIXED: Add this line FIRST
        $table->unsignedBigInteger('parent_id')->nullable()->default(null);
        $table->integer('likes')->default(0);
        $table->integer('reply_num')->default(0);
        $table->timestamps();
        
        // Then add the foreign key constraint
        $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
        $table->index('car_id');
        $table->index('parent_id');
    });
}
        // Create comment_likes table for tracking likes
   public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}
