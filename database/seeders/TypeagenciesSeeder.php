<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeagenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typeplaces')->insert([
            [
                'description' => 'Agencia',
                
            ],
            [
                'description' => 'Promotor',
            ],
            [
                'description' => 'Festival',
            ],
            
            
           
        ]);
    }
}
