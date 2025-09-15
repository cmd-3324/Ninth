<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarUser;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarUser>
 */
class CarUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

           return [
    'UserName' => $this->faker->userName(),          // Username, a string
    'email' => $this->faker->unique()->safeEmail(),                         // Email, properly formatted
    'Active' => $this->faker->boolean(80),                                   // Active status, true/false
    'phone_number' => $this->faker->phoneNumber(),                         // Phone number as string
    'Location' => $this->faker->city(),                                   // Location as city name string
    'Avatar' => 'BATCH-' . $this->faker->unique()->numberBetween(1000, 9999), // Some unique batch code
    'password' => bcrypt('password'),                                       // Password hashed string
];


    }
}
