<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilindoProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://api-splp.layanan.go.id/master_data_wilayah_provinsi/2.0');
        $records = $response->object();

        $provinces = [];
        if (count($records->data)) {
            foreach ($records->data as $dt) {
                $name = $dt->nama_provinsi == 'DKI JAKARTA' ? 'DKI Jakarta' : Str::title(Str::lower($dt->nama_provinsi));
                $provinces[] = [
                    'code' => $dt->kode_provinsi, 
                    'name' => $name
                ];
            }
        }

        DB::table(config('wilindo.prefix') . 'provinces')->truncate();
        DB::table(config('wilindo.prefix') . 'provinces')->insert($provinces);
    }
}
