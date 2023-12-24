<?php

namespace Database\Factories;

use App\Models\Agencies;
use App\Models\Artists;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ToursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cartels = [
            asset('storage/tours/tour1.jpeg'),
            asset('storage/tours/tour2.jpeg'),
            asset('storage/tours/tour3.jpeg'),
            asset('storage/tours/tour4.jpeg'),
        ];
        
        return [
            'tourname' => fake()->catchPhrase(),
            'startdate' => fake()->dateTimeBetween('now', '+1 month'),
            'enddate' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'notes' => fake()->paragraph(),
            'youtube_list' => 'https://www.youtube.com/embed/videoseries?si=39cHU3tmhy86GT1H&amp;list=PLhazrcQIhlEGnFQQ-Kyeg07oPVmfMfaqr',
            'spotify_list' => 'https://open.spotify.com/embed/playlist/3nzDoGB795nZ3cRY2OJrcW?utm_source=generator&theme=0',
            'agency_id' => function () {
                return Agencies::all()->random()->id;
            },
            'artist_id' => function () {
                return Artists::all()->random()->id;
            },
            'tourcartel' => fake()->unique()->randomElement($cartels),
            'active'=>true
        ];
    }
}
