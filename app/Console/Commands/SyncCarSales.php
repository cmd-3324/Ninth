<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class SyncCarSales extends Command
{
    protected $signature = 'cars:sync-sales';
    protected $description = 'Sync sell_number and available_as in cars table based on pivot table data';

    public function handle()
    {
        $this->info('Starting syncing car sales data...');

        $cars = DB::table('cars')->get();

        foreach ($cars as $car) {
            $soldCount = DB::table('car_user')
                ->where('car_id', $car->car_id)
                ->count();

            $totalStock = $car->sell_number + $car->available_as;

            $available = $totalStock - $soldCount;
            if ($available < 0) {
                $available = 0;
            }
        if (Auth::user()->Active==1){
            DB::table('cars')
                ->where('car_id', $car->car_id)
                ->update([
                    'sell_number' => $soldCount,
                    'available_as' => $available,
                ]);

            $this->info("Car ID {$car->car_id} updated: sold = {$soldCount}, available = {$available}");
        }

        $this->info('Sync complete!');
        return 0;
    }
}}
