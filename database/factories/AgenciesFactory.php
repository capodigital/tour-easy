<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agencies>
 */
class AgenciesFactory extends Factory
{
    protected $model = Agencies::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tradename' => fake()->company(),
            'taxname' => fake()->companySuffix() . ' ' . fake()->company(),
            'taxcode' => fake()->swiftBicNumber(),
            'owner' => fake()->name(),
            'address' => fake()->address(),
            'email' => fake()->companyEmail(),
            'web' => fake()->url(),
            'notes' => fake()->paragraph(),
            'phone' => fake()->phoneNumber(),
            'city_id' => function () {
                return Cities::all()->random()->id;
            },

        ];
    }
}
