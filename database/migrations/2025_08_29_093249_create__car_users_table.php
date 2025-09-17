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
            Schema::create('carsusers', function (Blueprint $table) {
               $table->bigIncrements('UserID'); // ← Your custom auto-increment primary key
                $table->string("UserName");
                $table->boolean("Active")->default(true);
               $table->string('email', 191)->unique();

                $table->timestamp('email_verified_at')->nullable();
                $table->string('phone_number')->nullable();
               $table->string('Location');
    // $table->decimal('latitude', 10, 8)->nullable()->after('address');
    // $table->decimal('longitude', 10, 8)->nullable()->after('latitude');
                //  $table->boolean('is_published')->default(false);
               $table->string('Avatar')->nullable(); 
                $table->string('password');
                $table->rememberToken();   
                $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("carsusers");
    }
};
