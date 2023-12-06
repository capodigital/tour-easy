<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Typeredes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Socialmedias>
 */
class SocialmediasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->paragraph(),
            'url' => fake()->url(),
            'typeredes_id' => function () {
                return Typeredes::all()->random()->id;
            },
            'socialmediaable_id' => null,
            'socialmediaable_type' => null,
        ];
    }

    public function artist()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Artists::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Artists',
            ];
        });
    }
    public function agency()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Agencies::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Agencies',
            ];
        });
    }
}
