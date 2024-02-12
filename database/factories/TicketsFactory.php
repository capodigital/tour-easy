<?php

namespace Database\Factories;

use App\Models\Currency;
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
            'amount' => fake()->numberBetween(10, 200),
            'wallet' => fake()->word(),
            'chain' => function () {
                $random = Currency::all()->random();
                return "$random->currency ($random->abbreviation)";
            },
            'notes' => fake()->paragraph(),
            'trans' => fake()->paragraph(),
            'itinerary_id' => function () {
                return Itineraries::all()->random()->id;
            },



        ];
    }
}
