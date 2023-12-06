<?php

namespace Database\Factories;

use App\Models\Agencies;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artists>
 */
class ArtistsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $images = [
            asset('storage/artists/artist1.jpeg'),
            asset('storage/artists/artist2.jpeg'),
            asset('storage/artists/artist3.jpeg'),
            asset('storage/artists/artist4.jpeg'),
        ];

        $stagename = fake()->userName();
        $tags = fake()->randomElements([
            'Pop', 'Rock', 'Jazz', 'Blues', 'Country', 'Rap', 'Reggae', 'Classical', 'Electronic', 'Folk', 'Hip Hop', 'R&B', 'Soul', 'Punk', 'Gospel', 'Heavy Metal', 'Latin', 'Dance', 'World Music', 'Funk', 'Disco', 'House', 'Techno', 'Trance', 'Alternative Rock', 'Indie Rock', 'Pop Rock', 'Hard Rock', 'Soft Rock', 'Progressive Rock', 'Psychedelic Rock', 'Punk Rock', 'Country Rock', 'Folk Rock', 'Blues Rock', 'Reggae Rock', 'Jazz Rock', 'Ska Punk', 'Pop Punk', 'Funk Rock', 'Rap Rock', 'Rock and Roll', 'Soul Jazz', 'Acid Jazz', 'Jazz Fusion', 'Smooth Jazz', 'Cool Jazz', 'Traditional Jazz', 'Latin Jazz', 'Gypsy Jazz', 'Jazz Blues', 'Swing', 'Bebop', 'Free Jazz', 'Big Band', 'Hard Bop', 'Modal Jazz', 'Vocal Jazz'
        ], 4);
        return [
            'stagename' => $stagename,
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'birthday' => fake()->dateTimeBetween('-100 years', '-15 years'),
            'notes' => fake()->paragraph(),
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'tags' => implode(', ', $tags),
            'image' => fake()->unique()->randomElement($images),
        ];

    }
}
