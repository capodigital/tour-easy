<?php

namespace Database\Factories;

use App\Models\Cities;
use App\Models\Persons;
use App\Models\Places;
use App\Models\Suppliers;
use App\Models\Tours;
use App\Models\Typeitineraries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itineraries>
 */
class ItinerariesFactory extends Factory
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
            'notes' => fake()->paragraph(),
            'outoftour' => fake()->boolean(),
            'startdate' => fake()->dateTimeBetween('4 days', '8 days'),
            'enddate' => fake()->dateTimeBetween('8 days', '12 days'),
            'carrier' => fake()->name(),
            'carrier_id' => fake()->swiftBicNumber(),
            'showcheck' => fake()->time(),
            'showtime' => fake()->time(),
            'notify' => false,

            'tour_id' => function () {
                return Tours::all()->random()->id;
            },
            'typeitinerary_id' => function () {
                return Typeitineraries::all()->random()->id;
            },
            'place_id' => function () {
                return Places::all()->random()->id;
            },
            'city_start_id' => function () {
                return Cities::all()->random()->id;
            },
            'city_destination_id' => function () {
                return Cities::all()->random()->id;
            },
            // 'person_id' => function () {
            //     return Persons::all()->random()->id;
            // },
            'supplier_id' => function () {
                return Suppliers::all()->random()->id;
            },

        ];
    }
}
