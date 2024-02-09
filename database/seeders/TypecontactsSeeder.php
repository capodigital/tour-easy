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
                'description' => 'Agente',
                
            ],
            [
                'description' => 'Manager',
            ],
            [
                'description' => 'Tour Manager',
            ],
            [
                'description' => 'Promotor',
            ],
            [
                'description' => 'Booking',
            ],
            [
                'description' => 'Técnico',
            ],
            [
                'description' => 'Chofer',
            ],
            [
                'description' => 'Proveedor',
            ],
            [
                'description' => 'Equipo Artista',
            ],
            [
                'description' => 'Personal Artista',
            ],
            [
                'description' => 'Seguridad',
            ],
            
           
        ]);
    }
}
