<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Contacts;
use App\Models\Documents;
use App\Models\Itineraries;
use App\Models\Places;
use App\Models\Socialmedias;
use App\Models\Suppliers;
use App\Models\Tours;
use App\Models\Typeagencies;
use App\Models\Typeitineraries;
use App\Models\Typeplaces;
use App\Models\User;
use Database\Factories\ItinerariesFactory;
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
        $this->call([
            TypecontactsSeeder::class,
           
        ]);
        $this->call([
            TypeitinerariesSeeder::class,
           
        ]);
        $this->call([
            TypeplacesSeeder::class,
           
        ]);
        $this->call([
            TypeagenciesSeeder::class,
           
        ]);
        $path1 = base_path() . '\database\seeders\Paises.sql_';
        $path2 = base_path() . '\database\seeders\Ciudades.sql_';
        $sql1 = file_get_contents($path1);
        $sql2 = file_get_contents($path2);
        DB::unprepared($sql1);
        DB::unprepared($sql2);

        Agencies::factory(2)->create();
        Socialmedias::factory(3)->agency()->create();
        Documents::factory(3)->agency()->create();

        Artists::factory(4)->create();
        Socialmedias::factory(10)->artist()->create();
        Documents::factory(3)->artist()->create();

            
        Tours::factory(4)->create();
        Socialmedias::factory(10)->tour()->create();
        Documents::factory(3)->tour()->create();

        Contacts::factory(10)->create();
        Socialmedias::factory(10)->contact()->create();
        Documents::factory(3)->contact()->create();

        Suppliers::factory(10)->create();
        Socialmedias::factory(10)->supplier()->create();
        Documents::factory(3)->supplier()->create();

        Places::factory(10)->create();

        Itineraries::factory(10)->create();


        $this->call([
            TourcontactsSeeder::class,
           
        ]);

        Places::factory(10)->create();
        Socialmedias::factory(10)->place()->create();
        Documents::factory(3)->place()->create();


        User::factory(1)->create();
    }
}
