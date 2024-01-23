<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Typecontacts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persons>
 */
class PersonsFactory extends Factory
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
            'birthday' => fake()->dateTimeBetween('-100 years', '-15 years'),
            'phone' => fake()->phoneNumber(),
            'extra_phone' => fake()->phoneNumber(),
            'lang' => fake()->randomElement(['Inglés','Español', 'Francés']),
            'notes' => fake()->paragraph(),
            'position' => fake()->sentence(),
            'notify' => false,
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'city_id' => function () {
                return Cities::all()->random()->id;
            },
            'typecontact_id' => function () {
                return Typecontacts::all()->random()->id;
            },
            
        ];
    }
}
