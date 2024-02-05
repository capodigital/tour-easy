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
                'url' => 'www.facebook.com',
                
            ],
            [
                'name' => 'Twitter',
                'logo' => asset('src/Twitter.png'),
                'url' => 'www.twitter.com',
            ],
            [
                'name' => 'Instagram',
                'logo' => asset('src/Instagram.png'),
                'url' => 'www.instagram.com',
            ],
            [
                'name' => 'Tiktok',
                'logo' => asset('src/Tiktok.png'),
                'url' => 'www.tiktok.com',
            ],
            [
                'name' => 'Spotify',
                'logo' => asset('src/Spotify.png'),
                'url' => 'www.spotify.com',
            ],
            [
                'name' => 'Youtube',
                'logo' => asset('src/Youtube.png'),
                'url' => 'www.youtube.com',
            ],
            [
                'name' => 'AppleMusic',
                'logo' => asset('src/AppleMusic.png'),
                'url' => 'www.applemusic.com',
            ],
            [
                'name' => 'AmazonMusic',
                'logo' => asset('src/AmazonMusic.png'),
                'url' => 'www.amazonmusic.com',
            ],
            [
                'name' => 'Tindal',
                'logo' => asset('src/Tindal.png'),
                'url' => 'www.tindal.com',
            ],
            [
                'name' => 'Web',
                'logo' => asset('src/Link.png'),
                'url' => 'www.tuweb.com',
            ],
        ]);
    }
}
