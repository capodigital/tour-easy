<?php

namespace Database\Seeders;

use App\Models\Agencies;
use App\Models\Contacts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourcontactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = Agencies::all();
        foreach ($agencies as $agency) {
            $tours = $agency->tours()->get();
            foreach ($tours as $tour) {
                DB::table('tourcontacts')->insert([
                    [
                        'tour_id' => $tour->id,
                        'contact_id' => Contacts::where('agency_id',$agency->id)->get()->random()->id
                    ]
                ]);
            }
        }
    }
}
