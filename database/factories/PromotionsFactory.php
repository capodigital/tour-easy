<?php

namespace Database\Factories;

use App\Models\Itineraries;
use App\Models\Tours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PromotionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'platform' => fake()->company(),
            'notes' => fake()->paragraph(),
            'itinerary_id' => function () {
                return Itineraries::all()->random()->id;
            },
            'tour_id' => function () {
                return Tours::all()->random()->id;
            },
            
            
        ];
    }
}
