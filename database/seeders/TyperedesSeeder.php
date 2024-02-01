<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TyperedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typesocialmedias')->insert([
            [
                'name' => 'Facebook',
                'logo' => asset('src/Facebook.png'),
                
            ],
            [
                'name' => 'Twitter',
                'logo' => asset('src/Twitter.png'),
            ],
            [
                'name' => 'Instagram',
                'logo' => asset('src/Instagram.png'),
            ],
            [
                'name' => 'Tiktok',
                'logo' => asset('src/Tiktok.png'),
            ],
            [
                'name' => 'Spotify',
                'logo' => asset('src/Spotify.png'),
            ],
            [
                'name' => 'Youtube',
                'logo' => asset('src/Youtube.png'),
            ],
            [
                'name' => 'AppleMusic',
                'logo' => asset('src/AppleMusic.png'),
            ],
            [
                'name' => 'AmazonMusic',
                'logo' => asset('src/AmazonMusic.png'),
            ],
            [
                'name' => 'Tindal',
                'logo' => asset('src/Tindal.png'),
            ],
            [
                'name' => 'Web',
                'logo' => asset('src/Link.png'),
            ],
        ]);
    }
}
