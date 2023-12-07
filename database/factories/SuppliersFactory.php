<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suppliers>
 */
class SuppliersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'supplier_name' => fake()->name(),
            'tax_code' => fake()->swiftBicNumber(),
            'email' => fake()->email(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'extra_phone' => fake()->phoneNumber(),
            'contact_manager' => fake()->name(),
            'notes' => fake()->paragraph(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->email(),
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'city_id' => function () {
                return Cities::all()->random()->id;
            },
            
            
        ];
    }
}
