<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarUser;
use App\Models\Car;

class CarUseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  public function definition(): array
{
    // Get or create a CarUser
    $carUser = CarUser::inRandomOrder()->first() ?? CarUser::factory()->create();
    
    // Get or create a Car
    $car = Car::inRandomOrder()->first() ?? Car::factory()->create();

    return [
        'UserID' => $carUser->UserID,
        'car_id' => $car->car_id,
    ];
}
}
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<
 */