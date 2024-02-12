<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Groups;
use App\Models\Language;
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
            'lang' => function () {
                return Language::all()->random()->name;
            },
            'notes' => fake()->paragraph(),
            'notify' => false,
            'position' => fake()->sentence(),
            'passport' => fake()->swiftBicNumber(),
            'passport_expiry' => fake()->dateTimeBetween('+1 years', '4 years'),
            'notify_type' => fake()->randomElement(['WhatsApp', 'Telegram', 'Correo', 'SMS']),
            'group_id' => function () {
                return Groups::all()->random()->id;
            },
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'country_id' => function () {
                return Countries::all()->random()->id;
            },
            'typecontact_id' => function () {
                return Typecontacts::all()->random()->id;
            },

        ];
    }
}
