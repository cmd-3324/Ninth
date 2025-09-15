<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToCarUserTable extends Migration
{
    public function up()
    {
        Schema::table('car_user', function (Blueprint $table) {
            $table->integer('bought_num')->default(1);
            $table->string('cvv');
            $table->string('card_number');
            $table->string('card_name');
            $table->string('recive_loc');
            $table->string('expiry_date');
            $table->text('description')->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->boolean('is_paid')->default(false);
        });
    }

    public function down()
    {
        Schema::table('car_user', function (Blueprint $table) {
            $table->dropColumn([
                'bought_num',
                'cvv',
                'card_number',
                'card_name',
                'recive_loc',
                'purchased_at',
                'is_paid',
            ]);
        });
    }
}




?>