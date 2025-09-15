<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER after_car_user_insert
            AFTER INSERT ON car_user
            FOR EACH ROW
            BEGIN
                UPDATE cars
                SET sell_number = sell_number + 1,
                    available_as = available_as - 1
                WHERE car_id = NEW.car_id
                AND available_as > 0;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_car_user_insert');
    }
};
