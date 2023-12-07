<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Typeplaces;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Places>
 */
class PlacesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $places = [
            '23.1245097,-82.3859821673449 ',
            '23.0138889,-82.6094444',
            '23.1415927,-82.3567098420046',
            '23.12572,-82.38807',
            '23.13747,-82.35867',
            '23.12314,-82.37196',
        ];

        return [
            'name' => fake()->name(),
            'google_id' => fake()->sentence(),
            'email' => fake()->email(),
            'manager' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'extra_phone' => fake()->phoneNumber(),
            'gis' => fake()->randomElement($places),
            'notes' => fake()->paragraph(),
            'address' => fake()->address(),
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'city_id' => function () {
                return Cities::all()->random()->id;
            },
            'typeplace_id' => function () {
                return Typeplaces::all()->random()->id;
            },
            
        ];
    }
}
