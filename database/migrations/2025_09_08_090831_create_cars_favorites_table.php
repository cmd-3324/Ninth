<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars_favorites', function (Blueprint $table) {
           ;
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('UserID')->constrained('carsusers')->onDelete('cascade');
           $table->primary(['UserID', 'car_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars_favorites');
    }
};
