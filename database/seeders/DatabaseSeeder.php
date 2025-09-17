<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\CarUser;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Database\Eloquent\Model::unsetEventDispatcher();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('car_user')->truncate();
        DB::table('cars')->truncate();
        DB::table('carsusers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "=== Seeding Users ===\n";
        $users = CarUser::factory()->count(10)->create();
        echo "Created {$users->count()} users\n";

        echo "\n=== Seeding Cars ===\n";
        $cars = Car::factory()->count(15)->create();
        echo "Created {$cars->count()} cars\n";

        // echo "\n=== Creating Car-User Relationships ===\n";
        // $relationships = [];
        // foreach ($users as $user) {
        //     $randomCars = $cars->random(rand(1, 3));
        //     foreach ($randomCars as $car) {
        //         $relationships[] = [
        //             'UserID'      => $user->UserID,
        //             'car_id'      => $car->car_id,
        //             'bought_num'  => rand(1, 3),
        //             'cvv'         => str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
        //             'card_number' => str_pad(rand(4000000000000000, 4999999999999999), 16, '0', STR_PAD_LEFT),
        //             'card_name'   => fake()->name(),
        //             'recive_loc'  => fake()->city(),
        //             'expiry_date' => fake()->creditCardExpirationDate()->format('m/y'),
        //             'description' => fake()->sentence(),
        //             'purchased_at'=> now(),
        //             'is_paid'     => true,
        //             'created_at'  => now(),
        //             'updated_at'  => now()
        //         ];
        //     }
        // }

        // DB::table('car_user')->insert($relationships);
        // echo "Created " . count($relationships) . " relationships\n";

        // echo "\n=== Updating Car Inventory ===\n";
        // foreach ($cars as $car) {
        //     $buyerCount = DB::table('car_user')
        //         ->where('car_id', $car->car_id)
        //         ->count();

        //     $car->update([
        //         'sell_number'  => $buyerCount,
        //         'available_as' => max(0, $car->available_as - $buyerCount)
        //     ]);
        }
    }

