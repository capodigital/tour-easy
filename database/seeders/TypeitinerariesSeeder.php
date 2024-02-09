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
                'description' => 'Vuelo Comercial',
            ],
            [
                'description' => 'Vuelo Privado',
            ],
            [
                'description' => 'Transfer',
            ],
            [
                'description' => 'Transporte terrestre',
            ],
            [
                'description' => 'Tren',
            ],
            [
                'description' => 'Alojamiento',
            ],
            [
                'description' => 'Show',
                
            ],
            [
                'description' => 'Actividad Prensa',
            ],
            [
                'description' => 'Actividad Fans',
            ],
            
            
            
            
           
        ]);
    }
}
