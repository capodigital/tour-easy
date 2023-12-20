<?php

namespace Database\Factories;

use App\Models\Itineraries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TicketsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'email' => fake()->email(),
            'amount' => fake()->numberBetween(10,200),
            'phone' => fake()->phoneNumber(),
            'wallet' => fake()->word(),
            'chain' => fake()->word(),
            'notes' => fake()->paragraph(),
            'itinerary_id' => function () {
                return Itineraries::all()->random()->id;
            },
           
            
            
        ];
    }
}
