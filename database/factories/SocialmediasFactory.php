<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Contacts;
use App\Models\Places;
use App\Models\Suppliers;
use App\Models\Tours;
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

    public function tour()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Tours::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Tours',
            ];
        });
    }

    public function contact()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Contacts::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Contacts',
            ];
        });
    }

    public function place()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Places::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Places',
            ];
        });
    }
    public function supplier()
    {
        return $this->state(function (array $attributes) {
            return [
                'socialmediaable_id' => Suppliers::inRandomOrder()->first()->id,
                'socialmediaable_type' => 'App\Models\Suppliers',
            ];
        });
    }
}
