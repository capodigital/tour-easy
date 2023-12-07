<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeitinerariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typeitineraries')->insert([
            [
                'description' => 'Show',
                
            ],
            [
                'description' => 'Actividad',
            ],
            [
                'description' => 'Servicio',
            ],
            [
                'description' => 'Transporte terrestre',
            ],
            [
                'description' => 'Hotel',
            ],
            [
                'description' => 'Avión',
            ],
            [
                'description' => 'Tren',
            ],
            [
                'description' => 'Transfer',
            ],
           
        ]);
    }
}
