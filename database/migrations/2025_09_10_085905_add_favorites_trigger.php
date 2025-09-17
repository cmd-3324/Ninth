<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFavoritesTrigger extends Migration
{
    public function up()
    {
        // Create trigger for INSERT
        DB::unprepared('
            CREATE TRIGGER after_favorites_insert 
            AFTER INSERT ON cars_favorites 
            FOR EACH ROW 
            BEGIN
                UPDATE cars 
                SET fav_num = (
                    SELECT COUNT(*) 
                    FROM cars_favorites 
                    WHERE car_id = NEW.car_id
                ) 
                WHERE car_id = NEW.car_id;
            END
        ');

        // Create trigger for DELETE
        DB::unprepared('
            CREATE TRIGGER after_favorites_delete 
            AFTER DELETE ON cars_favorites 
            FOR EACH ROW 
            BEGIN
                UPDATE cars 
                SET fav_num = (
                    SELECT COUNT(*) 
                    FROM cars_favorites 
                    WHERE car_id = OLD.car_id
                ) 
                WHERE car_id = OLD.car_id;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_favorites_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_favorites_delete');
    }
}