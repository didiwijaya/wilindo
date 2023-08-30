<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilindoCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://api-splp.layanan.go.id/master_data_kabkota/1.0/data_master_kode_kabupaten_kota/f0f8c2436e5e021a');
        $records = $response->object();

        $cities = [];
        if (count($records->data)) {
            foreach ($records->data as $dt) {
                $cities[] = [
                    'code' => str_replace('.', '', $dt->kode_kabkota), 
                    'province_code' => $dt->kode_provinsi, 
                    'name' => Str::title(Str::lower($dt->nama_kabkota))
                ];
            }
        }

        DB::table(config('wilindo.prefix') . 'cities')->truncate();

        $cities = collect($cities);
        $chunks = $cities->chunk(100);
        foreach ($chunks as $chunk) {
            DB::table(config('wilindo.prefix') . 'cities')->insert($chunk->toArray());
        }
    }
}
