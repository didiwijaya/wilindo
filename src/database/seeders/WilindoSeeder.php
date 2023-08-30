<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WilindoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            WilindoProvinceSeeder::class, 
            WilindoCitySeeder::class, 
            WilindoDistrictSeeder::class, 
            WilindoVillageSeeder::class
        ]);
    }
}
