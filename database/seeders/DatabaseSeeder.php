<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Socialmedias;
use App\Models\Tours;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            TyperedesSeeder::class,
           
        ]);
        $path1 = base_path() . '\database\seeders\Paises.sql_';
        $path2 = base_path() . '\database\seeders\Ciudades.sql_';
        $sql1 = file_get_contents($path1);
        $sql2 = file_get_contents($path2);
        DB::unprepared($sql1);
        DB::unprepared($sql2);

        Agencies::factory(2)->create();
        Socialmedias::factory(3)->agency()->create();

        Artists::factory(4)->create();
        Socialmedias::factory(10)->artist()->create();

            
        Tours::factory(4)->create();
        Socialmedias::factory(10)->tour()->create();


        User::factory(1)->create();
    }
}
