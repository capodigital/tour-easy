<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/seeders/cities.json");

        $data = json_decode($json);

        foreach ($data as $obj) {
            DB::table('cities')->insert([
                'name' => $obj->name,
                'country_id' => $obj->country_id,
                'code' => $obj->code,
            ]);
        }
    
    }
}
