<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Artists;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ToursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cartels = [
            asset('storage/tours/tour1'),
            asset('storage/tours/tour2'),
            asset('storage/tours/tour3'),
            asset('storage/tours/tour4'),
        ];
        return [
            'tourname' => fake()->catchPhrase(),
            'startdate' => fake()->dateTimeBetween('now', '+1 month'),
            'enddate' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'web' => fake()->url(),
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'artist_id' => function () {
                return Artists::all()->random()->id;
            },
            'tourcartel' => fake()->unique()->randomElement($cartels),
        ];
    }
}
