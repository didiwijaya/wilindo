<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WilindoDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://api-splp.layanan.go.id/master_data_kecamatan/1.0/data_master_kode_kecamatan/830386d3474db18f');
        $records = $response->object();

        $districts = [];
        if (count($records->data)) {
            foreach ($records->data as $dt) {
                $districts[] = [
                    'code' => str_replace('.', '', $dt->kode_kecamatan), 
                    'city_code' => str_replace('.', '', $dt->kode_kabkota), 
                    'name' => $dt->nama_kecamatan
                ];
            }
        }

        DB::table(config('wilindo.prefix') . 'districts')->truncate();

        $districts = collect($districts);
        $chunks = $districts->chunk(500);
        foreach ($chunks as $chunk) {
            DB::table(config('wilindo.prefix') . 'districts')->insert($chunk->toArray());
        }
    }
}
