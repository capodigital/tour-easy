<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypecontactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typecontacts')->insert([
            [
                'description' => 'Artista',
                
            ],
            [
                'description' => 'Manager',
            ],
            [
                'description' => 'Promotor',
            ],
            [
                'description' => 'Chofer',
            ],
            [
                'description' => 'Crew',
            ],
            [
                'description' => 'Tech',
            ],
           
        ]);
    }
}
