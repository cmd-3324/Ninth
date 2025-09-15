<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'car_id' => $this->faker->unique()->randomNumber(6),
        'name' => $this->faker->unique()->company(),
        'available_as' => $this->faker->numberBetween(2, 10), // Stock quantity
        'sell_number' => 0, // CHANGE THIS: Start at 0, not random!
        'fav_num' =>0,
        'price' => $this->faker->numberBetween(5000, 100000),
        'engine' => 'ENG-' . $this->faker->unique()->numberBetween(1000, 9999),
        'horsepower' => $this->faker->numberBetween(70, 360),
        'torque' => $this->faker->numberBetween(100, 500),
        'main_image' => $this->faker->imageUrl(640, 480, 'transport', true),
        'gallery_images' => json_encode([
            $this->faker->imageUrl(640, 480, 'transport', true),
            $this->faker->imageUrl(640, 480, 'transport', true),
            $this->faker->imageUrl(640, 480, 'transport', true),
        ]),
        'discription' => $this->faker->paragraph(),
    ];
}
}
