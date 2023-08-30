<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WilindoVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $response = Http::get('https://api-splp.layanan.go.id/master_data_desakelurahan/1.0/data_master_kode_desa_kelurahan/eefd56bc6663e0d1');
        $records = $response->object();

        $villages = [];
        if (count($records->data)) {
            foreach ($records->data as $dt) {
                $villages[] = [
                    'code' => str_replace('.', '', $dt->kode_desa_kelurahan), 
                    'district_code' => str_replace('.', '', $dt->kode_kecamatan), 
                    'name' => $dt->nama_desa_kelurahan
                ];
            }
        }

        DB::table(config('wilindo.prefix') . 'villages')->truncate();

        $villages = collect($villages);
        $chunks = $villages->chunk(2500);
        foreach ($chunks as $chunk) {
            DB::table(config('wilindo.prefix') . 'villages')->insert($chunk->toArray());
        }
    }
}
