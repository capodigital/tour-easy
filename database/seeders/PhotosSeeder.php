<?php

namespace Database\Seeders;

use App\Models\Tours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = Tours::all();
        foreach ($tours as $tour) {
            for ($i = 0; $i < 20; $i++) {
                DB::table('photos')->insert([
                    [
                        'url' => "src/luis-fonsi/". ($i+1) . ".jpg",
                        'tour_id' => $tour->id,
                    ]
                ]);
            }
        }
    }
}
