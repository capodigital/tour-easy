<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Contacts;
use App\Models\Places;
use App\Models\Suppliers;
use App\Models\Tours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documents>
 */
class DocumentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'url' => fake()->url(),
            'document_path' => fake()->url(),
            'size' => fake()->numberBetween(1,1024),
            'ext' => '.doc',
            'documentable_id' => null,
            'documentable_type' => null,
        ];
    }

    public function artist()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Artists::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Artists',
            ];
        });
    }
    public function agency()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Agencies::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Agencies',
            ];
        });
    }

    public function tour()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Tours::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Tours',
            ];
        });
    }

    public function contact()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Contacts::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Contacts',
            ];
        });
    }

    public function place()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Places::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Places',
            ];
        });
    }
    public function supplier()
    {
        return $this->state(function (array $attributes) {
            return [
                'documentable_id' => Suppliers::inRandomOrder()->first()->id,
                'documentable_type' => 'App\Models\Suppliers',
            ];
        });
    }
}
